<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Group;
use App\Models\Syllabus;
use App\Models\Role;
use Auth;
use Image;
use Toastr;
use File;
use Session;

class SyllabusCtrl extends Controller
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
        $syllabus = Syllabus::orderBy('id','DESC')->get();
        return view('layouts.syllabuses.index', compact('syllabus'));
    }
    
    public function view($id)
    {
        if(!is_null(Session::get('_paper')))
        {
            Session::forget('_paper');
        }
        $syllabus = Syllabus::find($id);
        return view('layouts.syllabuses.view', compact('syllabus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::orderBy('id', 'DESC')->where('status', 'Active')->get();
        return view('layouts.syllabuses.create', compact('courses'));
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
            'course_id' => 'required|numeric',
            'name'      => 'required|unique:groups|max:255',
            'header'    => 'required',
            'details'   => 'nullable|max:1000',
        ]);
        
        $data = $request->all();
        if(isset($data['_token']))
        {
            unset($data['_token']);
        }

        if(isset($data['status']))
        {
            $data['status'] = 'Active';
        }
        else
        {
            $data['status'] = 'Deactive';
        }

        $data['created_by'] = Auth::id();

        try{
            Syllabus::insert($data);
        }
        catch(\E $e)
        {
            return $e;
        }

        // $batch = Group::orderBy('id', 'DESC')->first();
        
        Session::flash('success', 'New syllabus successfully created!');

        return redirect()->route('syllabus.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::find($id);
        return view('layouts.groups.read', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::find($id);
        return view('layouts.groups.edit', compact('group'));
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
            Group::where('id', $id)->update($data);
        }
        catch(\E $e)
        {
            return $e;
        }
        
        Session::flash('success', 'The group successfully Updated!');

        return redirect()->route('group.index');
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
            $group = Group::find($id);

            // delete all relationship
            // $group->papers()->detach();

            //delete group table
            $group->delete();

            Session::flash('Success','The group successfully deleted');
            return redirect()->route('group.index');
        }

        Session::flash('error', 'Permission restricted!');
        return back();
    }

    //custom routes
    public function addQuestion($type, $id)
    {
        $paper = Syllabus::find($id);
        $paper['type'] = $type;
        if($paper)
        {
            Session::put('_paper', $paper);
            return redirect()->route('question.view');
        }
        return back();
    }

    public function addToPaper(Request $request)
    {
        $data = $request->all();
        $ids = explode(',', $data['question']);
        if(!is_null(Session::get('_paper')))
        {
            $paper = Session::get('_paper');
            if($data['action'] == 'add')
            {
                $qcount = $paper->questions()->attach($ids);
            }
            else
            {
                $qcount = $paper->questions()->detach($ids);
            }

            $paper = Syllabus::find($paper->id);
            Session::put('_paper', $paper);

            return response()->json([
                'success' => true,
                'message' => 'The question added to the syllabus',
                'qcount' => $qcount
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'We are getting error'
        ]);
    }
    
}