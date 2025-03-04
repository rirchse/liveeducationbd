<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Group;
use App\Models\Exam;
use App\Models\Role;
use App\Models\Paper;
use App\Models\Choice;
use App\Models\Question;
use Auth;
use Image;
use Toastr;
use File;
use Session;

class ExamCtrl extends Controller
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
        $exams = Exam::orderBy('id','DESC')->paginate(25);
        return view('layouts.exams.index', compact('exams'));
    }

    public function live()
    {
        $exams = Exam::orderBy('id','DESC')
        ->where('status', 'Live')
        ->whereRaw('DATE(created_at) = ?', [date('Y-m-d')])
        ->paginate(100);

        // return response()->json([
        //     'success' => true,
        //     'exams' => $exams
        // ]);
        
        return view('layouts.exams.live', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('layouts.exams.create');
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
            Exam::insert($data);
        }
        catch(\E $e)
        {
            return $e;
        }

        // $batch = Exam::orderBy('id', 'DESC')->first();
        
        Session::flash('success', 'New exam successfully created!');

        return redirect()->route('exam.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exam = Exam::find($id);
        return view('layouts.exams.read', compact('exam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exam = Exam::find($id);
        return view('layouts.exams.edit', compact('exam'));
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
            Exam::where('id', $id)->update($data);
        }
        catch(\E $e)
        {
            return $e;
        }
        
        Session::flash('success', 'The exam successfully Updated!');

        return redirect()->route('exam.index');
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
            $exam = Exam::find($id);

            // delete all relationship
            $exam->choices()->delete();

            //delete group table
            $exam->delete();

            Session::flash('Success','The exam successfully deleted');
            return redirect()->route('paper.exam', $exam->paper_id);
        }

        Session::flash('error', 'Permission restricted!');
        return back();
    }

    // customized methods
    public function paper($exam_id)
    {
        $exam = Exam::find($exam_id);
        $paper = Paper::find($exam->paper_id);
        $questions = $paper->questions()
        // ->leftJoin('choices', 'choices.question_id', 'questions.id')
        // ->where('choices.exam_id', $exam_id)
        // ->select('choices.*', 'questions.title')
        ->select('questions.title')
        ->paginate(20);

        $choices = Choice::where('exam_id', $exam_id)
        ->pluck('question_id', 'mcq_id')
        ->toArray();
        // dd($questions);

        return view('layouts.exams.paper', compact('exam', 'questions', 'paper', 'choices'));
    }
    
}
