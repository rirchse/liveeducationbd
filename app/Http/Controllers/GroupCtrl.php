<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Group;
use App\Models\Role;
use Auth;
use Image;
use Toastr;
use File;
use Session;

class GroupCtrl extends Controller
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
        $groups = Group::orderBy('id','DESC')->get();
        return view('layouts.groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.groups.create');
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
            'name'      => 'required|unique:groups|max:255',
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

        try{
            Group::insert($data);
        }
        catch(\E $e)
        {
            return $e;
        }

        // $batch = Group::orderBy('id', 'DESC')->first();
        
        Session::flash('success', 'New group successfully created!');

        return redirect()->route('group.index');
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
    
}
