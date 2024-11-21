<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

class HomePageCtrl extends Controller
{
  public function index()
  {
    $mycourses = [];
    $user = Auth::guard('student')->user();
    if($user)
    {
      $student = Student::find($user->id);
      $mycourses = $student->courses()->orderBy('id', 'DESC')->get();
    }
    // active courses
    $courses = Course::orderBy('id', 'DESC')->where('status', 'Active')->get();

    // Active batches
    $batches = Batch::where('status', 'Active')->get();

    $batch_ids = Batch::pluck('id')->toArray();
    $papers = Paper::orderBy('id', 'DESC')->whereIn('batch_id', $batch_ids)->get();
    return view('student-panel.index', compact('courses', 'mycourses', 'batches', 'papers'));
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

  public function result($id)
  {
    $user = Auth::guard('student')->user();
    $exams = Exam::where('student_id', $user->id)->where('paper_id', $id)->get();
    $paper = Paper::find($id);
    $result = 'Yes';

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
      'question_id' => 'required|string',
      'mcq_id' => 'required|string',
    ]);

    $questions = $answered = $correct = $wrong = $no_answered = $marks = 0;

    $question_ids = explode(',', $request->question_id);
    $mcq_ids = explode(',', $request->mcq_id);

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
      $exam->answer = $answered;
      $exam->correct = $correct;
      $exam->wrong = $wrong;
      $exam->no_answer = $no_answered;
      $exam->mark = $marks;
      $exam->save();

      for($x = 0; $x < count($question_ids); $x++)
      {
        Choice::insert([
          'exam_id' => $exam->id,
          'question_id' => $question_ids[$x],
          'mcq_id' => $mcq_ids[$x]
        ]);
      }
    }catch(\E $e)
    {
      return $e;
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
}