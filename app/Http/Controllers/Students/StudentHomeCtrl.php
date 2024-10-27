<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Paper;
use App\Models\Student;
use App\Models\Batch;
use App\Models\Department;
use App\Models\Group;
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
    $paper = Paper::find($id);
    return view('student-panel.exam-show', compact('paper'));
  }
}