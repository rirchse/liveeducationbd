<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Role;
use App\Models\Vendor;
use Auth;
use Image;
use Toastr;
use File;
use Session;

class CourseCtrl extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::orderBy('id','desc')->get();
        return view('layouts.courses.index',compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|unique:courses|max:255',
            'details'   => 'nullable|max:1000',
        ]);
        
        $data = $request->all();
        if(isset($data['_token']))
        {
            unset($data['_token']);
        }

        $data['status'] = 'Active';

        try{
            Course::insert($data);
        }
        catch(\E $e)
        {
            return $e;
        }

        $course_id = Course::orderBy('id', 'DESC')->first()->id;
        
        Session::flash('success', 'New course successfully created!');

        return redirect()->route('course.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::find($id);
        return view('layouts.courses.read', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::find($id);
        return view('layouts.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'      => 'required|max:255',
            'details'   => 'nullable|max:1000',
        ]);
        
        $data = $request->all();

        if(isset($data['_token']))
        {
            unset($data['_token']);
        }
        if(isset($data['_method']))
        {
            unset($data['_method']);
        }

        try{
            Course::where('id', $id)->update($data);
        }
        catch(\E $e)
        {
            return $e;
        }
        
        Session::flash('success', 'The course successfully Update!');

        return redirect()->route('course.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->AuthorizeRoles('SuperAdmin'))
        {
            $course = Course::find($id);

            // delete all relationship
            $course->departments()->detach();
            $course->semesters()->detach();
            $course->subjects()->detach();
            // $course->chapters()->detach();
            $course->questions()->detach();
            $course->filters()->detach();

            //delete course table
            $course->delete();

            Session::flash('Success','The course successfully deleted');
            return redirect()->route('course.index');
        }

        Session::flash('error', 'Permission restricted!');
        return back();
    }
    
}
