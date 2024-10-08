<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filter;
use App\Models\SubFilter;
use App\Models\Role;
use App\Models\Label;
use App\Models\Paper;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Department;
use Auth;
use Image;
use Toastr;
use File;
use Session;
use Validator;

class PaperCtrl extends Controller
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
        $papers = Paper::orderBy('id','DESC')
        ->paginate(25);
        return view('layouts.papers.index', compact('papers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::where('status', 'Active')->get();
        $batches = Batch::where('status', 'Active')->get();
        $departments = Department::where('status', 'Active')->get();
        return view('layouts.papers.create', compact('courses', 'batches', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $source = new SourceCtrl;
        $validator = Validator::make($request->all(), [
            'header' => 'required',
            'banner' => 'mimes:jpeg,jpg,png,pdf|max:1000',
        ]);

        // if($validator->fails()){
        //     return response()->json(
        //         [
        //             'success' => false,
        //             'message' => 'File upload failed',
        //             'errors' => $validator->getMessageBag()->toArray()
        //         ],
        //         201
        //     );
        // }
        
        $data = $request->all();
        // dd($data);

        if(isset($data['_token']))
        {
            unset($data['_token']);
        }

        if(isset($data['banner']))
        {
            $data['banner'] = $source->uploadImage($data['banner'], 'papers/');
        }

        if(!isset($data['format']))
        {
            $data['format'] = 0;
        }

        try{
            Paper::insert($data);
        }
        catch(\E $e)
        {
            return $e;
        }

        $paper = Paper::orderBy('id', 'DESC')->first();

        // return response()->json(['success' => 'true', 'message' => 'File successfully uploaded!', 'paper' => $paper], 200);
        Session::flash('success', 'The question paper successfully created.');
        return redirect()->route('paper.show', $paper->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\subfilter  $subfilter
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $paper = Paper::find($id);
        return view('layouts.papers.read', compact('paper'));
    }

    public function view($id)
    {
        if(!is_null(Session::get('_paper')))
        {
            Session::forget('_paper');
        }
        $paper = Paper::find($id);
        return view('layouts.papers.view', compact('paper'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\subfilter  $subfilter
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $courses = Course::where('status', 'Active')->get();
        $batches = Batch::where('status', 'Active')->get();
        $departments = Department::where('status', 'Active')->get();
        $paper = Paper::find($id);
        return view('layouts.papers.edit', compact('paper', 'courses', 'batches', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\subfilter  $subfilter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $source = new SourceCtrl;
        $validator = Validator::make($request->all(), [
            'header' => 'required',
            'banner'   => 'nullable|image|mimes:jpeg,jpg,png,pdf|max:1000',
        ]);

        if($validator->fails()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'File upload failed',
                    'errors' => $validator->getMessageBag()->toArray()
                ],
                201
            );
        }

        $paper = Paper::find($id);
        $xbanner = public_path($paper->banner);
        
        $data = $request->all();

        if(isset($data['_token']))
        {
            unset($data['_token']);
        }

        if(isset($data['_method']))
        {
            unset($data['_method']);
        }

        if(isset($data['banner']))
        {
            $data['banner'] = $source->uploadImage($data['banner'], 'papers/');
        }

        try{
            Paper::where('id', $id)->update($data);

            if(File::exists($xbanner))
            {
                File::delete($xbanner);
            }
        }
        catch(\E $e)
        {
            return $e;
        }

        $paper = Paper::find($id);
        Session::flash('success', 'The question paper successfully updated!');
        
        return redirect()->route('paper.edit', $paper->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\subfilter  $subfilter
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = AnswerFile::find($id);
        $xfile = public_path($file->file);
           
        if (File::exists($xfile)) {
            File::delete($xfile);
        }
        $file->delete();

        return response()->json([
            'success' => true,
            'message' => 'File successfully deleted!',
            'file' => $file
        ]);
    }

    //custom routes
    public function addQuestion($id)
    {
        $paper = Paper::find($id);
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
            $qcount = $paper->questions()->sync($ids);

            $paper = Paper::find($paper->id);
            Session::put('_paper', $paper);

            return response()->json([
                'success' => true,
                'message' => 'The question added to the paper',
                'qcount' => $qcount
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'We are getting error'
        ]);
    }
    
}
