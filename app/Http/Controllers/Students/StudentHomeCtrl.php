<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SourceCtrl;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Paper;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Student;
use App\Models\Batch;
use App\Models\Department;
use App\Models\Group;
use App\Models\McqItem;
use App\Models\Choice;
use App\Models\Syllabus;
use App\Models\Complain;
use Auth;
use Session;
use Mail;
// use \Mpdf\Mpdf as PDF; 
// use Illuminate\Support\Facades\Storage;
use PDF;

class StudentHomeCtrl extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:student');
  }

  public function home()
  {
    // $user = Auth::guard('student')->user();
    // // active courses
    // $courses = Course::orderBy('id', 'DESC')->where('status', 'Active')->get();

    // // autheticates user courses
    // $student = Student::find($user->id);
    // $mycourses = $student->courses()->orderBy('id', 'DESC')->get();

    // // authenticates user examps
    // // $batch_ids = $student->batches()->pluck('id')->toArray();
    // $papers = Paper::orderBy('id', 'DESC')->whereIn('status', ['Published', 'Scheduled'])->where('permit', 'Every One')->get();
    // return view('student-panel.home', compact('courses', 'mycourses', 'papers', 'student'));

    return redirect()->route('students.my-course');
  }

  public function course()
  {
    $courses = Batch::orderBy('id', 'DESC')->where('status', 'Active')->get();
    return view('student-panel.course', compact('courses'));
  }

  public function courseShow($id)
  {
    $batch = Batch::find($id);
    // $batches = Batch::where('status', 'Active')->get();
    $departments = $batch->departments()->where('status', 'Active')->get();
    $groups = Group::where('status', 'Active')->get();
    return view('student-panel.course-show', compact('batch', 'departments', 'groups'));
  }

  public function applyCourse(Request $request)
  {
    $this->validate($request, [
      'batch_id' => 'required|numeric',
      'department_id' => 'required|numeric',
    ]);

    $data = $request->all();

    $user = Auth::guard('student')->user();
    $student = Student::find($user->id);
    if($student->courses()->find($request->course_id))
    {
      Session::flash('error', 'You already applied to the course.');
      return redirect()->route('students.my-course');
    }

    Session::put('_confirm', [
      'batch_id' => $data['batch_id'],
      'department_id' => $data['department_id'],
    ]);

    return redirect()->route('students.course.confirm');
  }

  public function confirm()
  {
    if(Session::get('_confirm'))
    {
      $data = Session::get('_confirm');
      $batch = Batch::find($data['batch_id']);
      $department = Department::find($data['department_id']);
      return view('student-panel.course-confirm', compact('batch', 'department'));
    }
    return redirect()->route('students.course');
  }

  public function courseApplied()
  {
    $student->batches()->attach($request->batch_id);
    $student->departments()->attach($request->department_id);

    Session::flash('success', 'You have successfully applied to the course.');
    return redirect()->route('students.my-course');
  }

  public function myCourse()
  {
    $user = Auth::guard('student')->user();
    $student = Student::find($user->id);
    $courses = $student->batches()->orderBy('id', 'DESC')->where('status', 'Active')->get();
    return view('student-panel.my-course', compact('courses'));
  }

  public function exam()
  {
    $user = Auth::guard('student')->user();
    $papers = Paper::orderBy('id', 'DESC')->whereIn('status', ['Published', 'Scheduled'])->where('permit', 'Every One')->get();
    
    return view('student-panel.exam', compact('papers'));
  }

  public function check($id)
  {
    $user = Auth::guard('student')->user();
    $check = [];
    $exams = Exam::where('paper_id', $id)->where('student_id', $user->id)->count();
    $paper = Paper::find($id);
    
    if($paper->status == 'Scheduled' && $paper->open && $paper->open >= date('Y-m-d H:i:s'))
    {
      $check['scheduled'] = true;
    }
    elseif($paper->status == 'Scheduled' && $paper->open <= date('Y-m-d H:i:s'))
    {
      Paper::where('id', $id)->update(['status' => 'Published']);
      $paper = Paper::find($id);
    }
    elseif($paper->exam_limit && $paper->exam_limit <= $exams)
    {
      return redirect()->route('students.result', $id);
    }
    elseif($paper->exam_limit && $paper->exam_limit > $exams)
    {
      $check['result-exam'] = true;
    }
    elseif($exams && is_null($paper->exam_limit))
    {
      $check['result-exam'] = true;
    }
    else{
      return redirect()->route('students.instruction', $id);
    }

    // dd($check);
    
    return view('student-panel.check', compact('paper', 'check'));
  }

  public function instruction($id)
  {
    $user = Auth::guard('student')->user();
    $paper = Paper::find($id);
    return view('student-panel.instruct', compact('paper'));
  }

  public function examShow($id)
  {
    $user = Auth::guard('student')->user();
    $exams = Exam::where('paper_id', $id)
    ->where('student_id', $user->id)
    ->where('status', 'Completed')
    ->count();
    $paper = Paper::find($id);
    // if on the paper settings has exam limitation and exam limitation number is less than already examed count on this paper. So it will redirect to the result page. Otherwise it will redirect to the exam start page.
    if($paper->exam_limit && $paper->exam_limit <= $exams)
    {
      //find paper
      $exams = Exam::where('paper_id', $paper->id)
      ->where('student_id', $user->id)
      ->get();
      $exam_id = Exam::where('paper_id', $paper->id)->orderBy('id', 'DESC')->first()->id;
      $mcq_ids = Choice::where('exam_id', $exam_id)->pluck('mcq_id')->toArray();
      $dbmcqs = McqItem::whereIn('id', $mcq_ids)->whereNotNull('correct_answer')->get();

      $questions = $paper->questions()->count();
      $answered = count($mcq_ids);
      $correct = $dbmcqs->count();
      $wrong = $answered - $correct;
      $no_answered = $questions - $answered;
      $marks = ($paper->mark * $correct) - ($wrong * $paper->minus);

      $result = [
        'questions' => $questions,
        'answered' => $answered,
        'correct' => $correct,
        'wrong' => $wrong,
        'no_answered' => $no_answered,
        'marks' => $marks,
      ];

      return view('student-panel.exam-show', compact('paper', 'result', 'exams'));
    }

    //insert exam to the database with status 'live'
    try {
      $live_exam = Exam::insert([
        'student_id' => $user->id,
        'paper_id' => $id,
        'start_at' => date('Y-m-d H:i:s'),
        'status' => 'Live',
        'created_at' => date('Y-m-d H:i:s')
      ]);

      if($live_exam)
      {
        // find out the last exam entry for this user
        $exam = Exam::where('paper_id', $id)
        ->where('student_id', $user->id)
        ->orderBy('id', 'DESC')
        ->first();
        
        return view('student-panel.exam-show', compact('paper', 'exam'));
      }
    }
    catch(\Exception $e)
    {
      return $e;
    }

    return back();
  }

  public function result($id, $value = null)
  {
    $result = [];
    $position = '';
    $user = Auth::guard('student')->user();
    $exams = Exam::where('student_id', $user->id)->where('paper_id', $id)->get();
    $paper = Paper::find($id);
    if($value == 'after')
    {
      $exams = Exam::where('student_id', $user->id)->where('paper_id', $id)->orderBy('id', 'DESC')->limit(1)->get();
    }

    $all_exams = Exam::orderBy('mark', 'DESC')
    ->where('paper_id', $paper->id)
    ->get();
    foreach($all_exams as $key => $value)
    {
      if($user->id == $value->student_id)
      {
        $position = $key+1;
        break;
      }
    }
    // dd($position);

    $candidates = $all_exams->count();
    
    if($paper->result_view == 'Yes')
    {
      $result['result'] = 'Yes';
    }
    else
    {
      $result['message'] = 'Yes';
    }

    return view('student-panel.result', compact('exams', 'paper', 'result', 'position', 'candidates'));
  }

  public function examPaper($id)
  {
    $user = Auth::guard('student')->user();
    $exam = Exam::find($id);
    $paper = Paper::find($exam->paper_id);
    $choices = Choice::where('exam_id', $id)->pluck('mcq_id', 'question_id')->toArray();
    // dd($choices);
    return view('student-panel.your-exam-paper', compact('paper', 'choices', 'exam'));
  }

  public function solution($id)
  {
    $paper = Paper::find($id);
    return view('student-panel.solution', compact('paper'));
  }

  public function examAdd(Request $request)
  {
    $user = Auth::guard('student')->user();
    $this->validate($request, [
      'paper_id' => 'required|numeric',
      'exam_id' => 'required|numeric',
      'question_id' => 'nullable|string',
      'mcq_id' => 'nullable|string',
    ]);

    $questions = $answered = $correct = $wrong = $no_answered = $marks = 0;
    $question_ids = [];
    $mcq_ids = [];

    //find paper
    $paper = Paper::find($request->paper_id);

    // if choice any question the do this action
    if($request->mcq_id)
    {
      $question_ids = explode(',', $request->question_id); 
      $mcq_ids = explode(',', $request->mcq_id);
      
      $dbmcqs = McqItem::whereIn('id', $mcq_ids)->whereNotNull('correct_answer')->get();

      $questions = $paper->questions()->count();
      $answered = count($question_ids);
      $correct = $dbmcqs->count();
      $wrong = $answered - $correct;
      $no_answered = $questions - $answered;
      $marks = ($paper->mark * $correct) - ($wrong * $paper->minus);

    }

    try {
      Exam::where('id', $request->exam_id)->update([
        'end_at'    => date('Y-m-d H:i:s'),
        'answer'    => $answered,
        'correct'   => $correct,
        'wrong'     => $wrong,
        'no_answer' => $no_answered,
        'mark'      => $marks,
        'status'    => 'Completed',
        'updated_at' => date('Y-m-d H:i:s')
      ]);

      if($mcq_ids)
      {
        for($x = 0; $x < count($question_ids); $x++)
        {
          Choice::insert([
            'exam_id' => $request->exam_id,
            'question_id' => $question_ids[$x],
            'mcq_id' => $mcq_ids[$x]
          ]);
        }
      }
    }catch(\E $e)
    {
      return $e;
    }
    
    $exam = Exam::find($request->exam_id);
    if($paper->email == 'Yes')
    {
      $this->resultSendToMail($paper, $exam);
    }

    return response()->json([
      'success' => true,
      'message' => $paper->message,
      'questions' => $questions,
      'answered' => $answered,
      'correct' => $correct,
      'wrong' => $wrong,
      'no_answered' => $no_answered,
      'marks' => $marks,
    ]);
  }

  public function resultSendToMail($paper, $exam)
  {
    $source = new SourceCtrl;
    $user = Auth::guard('student')->user();
    $data = [
      'email_from' => 'noreply@liveeducationbd.com',
      'from_name' => 'LiveEducationBD',
      'email_to' => $user->email,
      'subject' => 'Result | Live Education BD',
      'candidate' => $user->name,
      'course_name' => $exam->paper->course?$exam->paper->course->name:'',
      'exam_no' => $exam->paper->name,
      'start_at' => $source->dtformat($exam->start_at),
      'end_at' => $source->dtformat($exam->end_at),
      'answered' => $exam->answered,
      'correct' => $exam->correct,
      'wrong' => $exam->wrong,
      'no_answer' => $exam->no_answer,
      'mark' => $exam->mark,
      'minus' => $exam->minus,
      'percentage' => 100 / $exam->paper->questions->count() * $exam->mark,
      'comments' => '<a target="_blank" href="'.$source->host().'/students/result/'.$paper->id.'/after">View Details</a>'
    ];

    Mail::send('mail.send_result_tomail', $data, function($message) use ($data)
    {
      $message->to($data['email_to'])->subject($data['subject']);
      $message->from($data['email_from'], $data['from_name']);
    });
  }

  public function syllabus($id)
  {
    $syllabus = Syllabus::find($id);
    return view('student-panel.syllabus', compact('syllabus'));
  }

  public function generatePDF($id)
  {
    $syllabus = Syllabus::find($id);

    // Setup a filename 
    // $documentFileName = "fun.pdf";

    // Create the mPDF document
    // $document = new PDF( [
    //   'mode' => 'utf-8',
    //   'format' => 'A4',
    //   'margin_header' => '3',
    //   'margin_top' => '20',
    //   'margin_bottom' => '20',
    //   'margin_footer' => '2',
    // ]); 
    // Set some header informations for output
  //   $header = [
  //     'Content-Type' => 'application/pdf',
  //     'Content-Disposition' => 'inline; filename="'.$documentFileName.'"'
  // ];

  // Write some simple Content
  // $document->WriteHTML('<h1 style="color:blue">TheCodingJack</h1>');
  // $document->WriteHTML('<p>Write something, just for fun!</p>');
   
  // Save PDF on your public storage 
  // Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));
   
  // Get file back from storage with the give header informations
  // return Storage::disk('public')->download($documentFileName, 'Request', $header); //

    $pdf = PDF::loadView('student-panel.syllabus-pdf', compact('syllabus'));

    return $pdf->download('Syllabus PDF.pdf');
    // return $pdf->stream('document.pdf');

    // return view('student-panel.syllabus-pdf', compact('syllabus'));
  }

  public function complain()
  {
    return view('student-panel.complain');
  }

  public function complainStore(Request $request)
  {
    $this->validate($request, [
      'name' => 'required|string',
      'email' => 'required|string',
      'contact' => 'required|string',
      'department' => 'required|string',
      'details' => 'required|string',
    ]);

    $data = $request->all();
    if(isset($data['_token']))
    {
      unset($data['_token']);
    }

    $data['status'] = 'New';

    $data['created_at'] = date('Y-m-d H:i:s');

    try {
      Complain::insert($data);
      Session::flash('success', 'আমরা আপনের মতামতটি গ্রহণ করেছি। আপনার বিনয়ী মতামতের জন্য ধন্যবাদ।');
      return redirect()->route('students.complain');
    }
    catch(\E $e)
    {
      return $e;
    }
  }
}