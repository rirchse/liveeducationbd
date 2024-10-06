<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Role;
use Auth;
use Image;
use Toastr;
use File;
use Session;

class BatchCtrl extends Controller
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
        $batches = Batch::orderBy('id','DESC')->get();
        return view('layouts.batches.index', compact('batches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.batches.create');
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
            'name'      => 'required|unique:batches|max:255',
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
            Batch::insert($data);
        }
        catch(\E $e)
        {
            return $e;
        }

        $batch = Batch::orderBy('id', 'DESC')->first();
        
        Session::flash('success', 'New batch successfully created!');

        return redirect()->route('batch.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $batch = Batch::find($id);
        return view('layouts.batches.read', compact('batch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $batch = Batch::find($id);
        return view('layouts.batches.edit', compact('batch'));
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
            Batch::where('id', $id)->update($data);
        }
        catch(\E $e)
        {
            return $e;
        }
        
        Session::flash('success', 'The batch successfully Updated!');

        return redirect()->route('batch.index');
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
            $course = Batch::find($id);

            // delete all relationship
            // $course->courses()->detach();
            // $course->departments()->detach();
            $course->papers()->detach();

            //delete course table
            $course->delete();

            Session::flash('Success','The batch successfully deleted');
            return redirect()->route('batch.index');
        }

        Session::flash('error', 'Permission restricted!');
        return back();
    }
    
}
