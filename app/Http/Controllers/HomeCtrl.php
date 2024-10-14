<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Course;
use App\Models\Department;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Filter;

class HomeCtrl extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Auth::user()->authorizeRoles(['SuperAdmin', 'Admin', 'Editor', 'Sales']);
        $data = [
          'courses' => Course::count(),
          'departments' => Department::count(),
          'semesters' => Semester::count(),
          'subjects' => Subject::count(),
          'chapters' => Chapter::count(),
          'questions' => Question::count(),
          'filters' => Filter::count(),
        ];
        return view('layouts.index', compact('data'));
    }

    /*
      public function someAdminStuff(Request $request)
      {
        $request->user()->authorizeRoles('manager');
        return view(‘some.view’);
      }
      */
}
