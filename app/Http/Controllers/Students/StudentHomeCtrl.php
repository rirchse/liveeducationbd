<?php

namespace App\Http\Controllers\Students;

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
    $student = Student::find($user->id);
    $batch_ids = $student->batches()->pluck('id')->toArray();
    $papers = Paper::orderBy('id', 'DESC')->whereIn('batch_id', $batch_ids)->get();
    return view('student-panel.home', compact('courses', 'mycourses', 'papers'));
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

  public function examShow($id)
  {
    $user = Auth::guard('student')->user();
    $exams = Exam::where('paper_id', $id)->where('student_id', $user->id)->count();
    $paper = Paper::find($id);
    if($paper->exam_limit <= $exams)
    {
      //find paper
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

      return view('student-panel.exam-show', compact('paper', 'result'));
    }
    
    return view('student-panel.exam-show', compact('paper'));
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