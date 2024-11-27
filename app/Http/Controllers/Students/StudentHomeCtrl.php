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
use Auth;
use Session;
use Mail;

class StudentHomeCtrl extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:student');
  }

  public function home()
  {
    $user = Auth::guard('student')->user();
    // active courses
    $courses = Course::orderBy('id', 'DESC')->where('status', 'Active')->get();

    // autheticates user courses
    $student = Student::find($user->id);
    $mycourses = $student->courses()->orderBy('id', 'DESC')->get();

    // authenticates user examps
    $batch_ids = $student->batches()->pluck('id')->toArray();
    $papers = Paper::orderBy('id', 'DESC')->whereIn('batch_id', $batch_ids)->get();
    return view('student-panel.home', compact('courses', 'mycourses', 'papers', 'student'));
  }

  public function course()
  {
    $courses = Course::orderBy('id', 'DESC')->where('status', 'Active')->get();
    return view('student-panel.course', compact('courses'));
  }

  public function courseShow($id)
  {
    $course = Course::find($id);
    $batches = Batch::where('status', 'Active')->get();
    $departments = Department::where('status', 'Active')->get();
    $groups = Group::where('status', 'Active')->get();
    return view('student-panel.course-show', compact('course', 'batches', 'departments', 'groups'));
  }

  public function applyCourse(Request $request)
  {
    $this->validate($request, [
      'course_id' => 'required|numeric',
      'batch_id' => 'required|numeric',
      'department_id' => 'nullable|numeric',
      'group_id' => 'nullable|numeric',
    ]);

    $data = $request->all();

    $user = Auth::guard('student')->user();
    $student = Student::find($user->id);
    if($student->courses()->find($request->course_id))
    {
      Session::flash('error', 'You already applied to the course.');
      // return back();
      return redirect()->route('students.my-course');
    }
    $student->courses()->attach($request->course_id);
    $student->batches()->attach($request->batch_id);
    $student->departments()->attach($request->department_id);
    $student->groups()->attach($request->group_id);

    Session::flash('success', 'You have successfully applied to the course.');
    return redirect()->route('students.my-course');
  }

  public function myCourse()
  {
    $user = Auth::guard('student')->user();
    $student = Student::find($user->id);
    $courses = $student->courses()->orderBy('id', 'DESC')->get();
    return view('student-panel.my-course', compact('courses'));
  }

  public function exam()
  {
    $user = Auth::guard('student')->user();
    $student = Student::find($user->id);
    $batch_ids = $student->batches()->pluck('id')->toArray();
    $papers = Paper::orderBy('id', 'DESC')->whereIn('batch_id', $batch_ids)->get();
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
    $exams = Exam::where('paper_id', $id)->where('student_id', $user->id)->count();
    $paper = Paper::find($id);
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
    
    return view('student-panel.exam-show', compact('paper'));
  }

  public function result($id, $value = null)
  {
    $result = [];
    $user = Auth::guard('student')->user();
    $exams = Exam::where('student_id', $user->id)->where('paper_id', $id)->get();
    $paper = Paper::find($id);
    if($value == 'after')
    {
      $exams = Exam::where('student_id', $user->id)->where('paper_id', $id)->orderBy('id', 'DESC')->limit(1)->get();
      if($paper->result_view == 'Yes')
      {
        $result['result'] = 'Yes';
      }
      else
      {
        $result['message'] = 'Yes';
      }
    }

    return view('student-panel.result', compact('exams', 'paper', 'result'));
  }

  public function solution($id)
  {
    $user = Auth::guard('student')->user();
    $exam = Exam::find($id);
    $paper = Paper::find($exam->paper_id);
    $choices = Choice::where('exam_id', $id)->pluck('mcq_id', 'question_id')->toArray();
    // dd($choices);
    return view('student-panel.solution', compact('paper', 'choices'));
  }

  public function examAdd(Request $request)
  {
    $user = Auth::guard('student')->user();
    $this->validate($request, [
      'paper_id' => 'required|numeric',
      'question_id' => 'nullable|string',
      'mcq_id' => 'nullable|string',
    ]);

    // dd($request->start_at);
    // dd(date('Y-m-d H:i:s'));

    $questions = $answered = $correct = $wrong = $no_answered = $marks = 0;
    $question_ids = [];
    $mcq_ids = []; 
    $question_ids = explode(',', $request->question_id); 
    $mcq_ids = explode(',', $request->mcq_id);
    // if($question_ids)
    // {
    //   $question_ids = explode(',', $request->question_id);
    // }
    // if($mcq_ids)
    // {
    //   $mcq_ids = explode(',', $request->mcq_id);
    // }

    //find paper
    $paper = Paper::find($request->paper_id);
    $dbmcqs = McqItem::whereIn('id', $mcq_ids)->whereNotNull('correct_answer')->get();

    $questions = $paper->questions()->count();
    $answered = count($question_ids);
    $correct = $dbmcqs->count();
    $wrong = $answered - $correct;
    $no_answered = $questions - $answered;
    $marks = ($paper->mark * $correct) - ($wrong * $paper->minus);

    try{
      $exam = new Exam;
      $exam->student_id = $user->id;
      $exam->paper_id = $paper->id;
      $exam->start_at = date('Y-m-d H:i:s', $request->start_at);
      $exam->end_at = date('Y-m-d H:i:s');
      $exam->answer = $answered;
      $exam->correct = $correct;
      $exam->wrong = $wrong;
      $exam->no_answer = $no_answered;
      $exam->mark = $marks;
      $exam->save();

      if($mcq_ids)
      {
        for($x = 0; $x < count($question_ids); $x++)
        {
          Choice::insert([
            'exam_id' => $exam->id,
            'question_id' => $question_ids[$x],
            'mcq_id' => $mcq_ids[$x]
          ]);
        }
      }
    }catch(\E $e)
    {
      return $e;
    }
    
    $exam = Exam::where('student_id', $user->id)->orderBy('id', 'DESC')->first();
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
}