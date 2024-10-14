<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Role;
use App\Models\RoleUser;
use Auth;
use Image;
use Toastr;
use File;
use Session;
use DB;

class StudentCtrl extends Controller
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
        $students = Student::orderBy('id','DESC')->paginate(25);
        return view('layouts.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('layouts.students.create', compact('roles'));
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
       $this->validate($request, [
            'name'      => 'required|max:255',
            'email'     => 'required|unique:students',
            'contact'   => 'required|unique:students',
            'image'     => 'nullable|image|mimes:jpeg,jpg,png,gif|max:500'
        ]);

       $user = new Student;
       $user->name       = $request->name;
       $user->contact    = $request->contact;
       $user->email      = $request->email;
       $user->password   = bcrypt($request->password);
       $user->status     = $request->status ?? 'Inactive';
       $user->created_by = Auth::id();
       
       if($request->hasFile('image'))
       {
        $user->image = $source->uploadImage($request->image, 'students/');
       }

        $user->save();

        Session::flash('success', 'User Successfully Save');
        return redirect()->route('student.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::find($id);
        return view('layouts.students.read', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->AuthorizeRoles('SuperAdmin'))
        {
            $user = Student::find($id);
            return view('layouts.students.edit', compact('user'));
        }

        Session::flash('error', 'Permission restricted!');

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'      => 'required|max:255',
            'contact'   => 'required',
            'email'     => 'required',
            'status'    => 'max:30',
            'image'     => 'nullable|image|mimes:jpeg,jpg,png,gif|max:500'
        ]);

        $student = Student::find($id);
        $student->name       = $request->input('name');
        $student->contact    = $request->input('contact');
        $student->email      = $request->input('email');
        $student->status     = $request->input('status') ?? 'Inactive';
        $student->updated_by = Auth::id();

        if($request->hasFile('image'))
        {
            $x_img_path = public_path($student->image);

            $user->image = $source->uploadImage($request->image, 'students/');

            if (File::exists($x_img_path)) {
                File::delete($x_img_path);
            }
        }
        $student->save();

        Session::flash('success', 'The Student Successfully Updated');
        return redirect()->route('student.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        if(File::exists($student->image))
        {
            File::delete($student->image);
        }

        $student->delete();
        Session::flash('success', 'Student Successfully Removed');
        return redirect()->route('student.index');
    }

    // ----------------------- profile route ------------

    public function profile()
    {
        $user = Auth::user();
        return view('layouts.profile.read', compact('user'));
    }

    public function profileEdit()
    {
        $user = Auth::user();
        return view('layouts.profile.edit', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'contact' => 'nullable'
        ]);

        $students = Student::find(Auth::id());
        $students->name       = $request->input('name');
        $students->contact    = $request->input('contact');
        $students->updated_by = Auth::id();

        if($request->hasFile('image'))
        {
            $x_img_path = public_path($students->image);

            if (File::exists($x_img_path)) {
                File::delete($x_img_path);
            }

            $image = $request->file('image');
            $img = $request->name.'_'.time() .'.'. $image->getClientOriginalExtension();
            $location =  public_path('/uploads/users/'.$img);
            Image::make($image)->save($location);
            $students->image = '/uploads/users/'.$img;
        }
        $students->save();

        Session::flash('success', 'Profile information updated');
        return redirect()->route('profile');
    }

    public function changePassword()
    {
        $profile = Student::find(Auth::id());
        return view('layouts.change_password', compact('profile'));
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required|min:8|max:32',
            'password'         => 'required|min:8|max:32|confirmed'
            ]);

        $user = Student::find(Auth::id());

        function passverify($curr, $dbpass){
            return password_verify($curr, $dbpass);
        }

        if(password_verify($request->current_password, $user->password) === false){
            Session::flash('error', 'Invalid password provided.');
            return redirect('/change_password');
        }else{
            $user = Student::find(Auth::id());
            $user->password = bcrypt($request->password);
            $user->save();

            Session::flash('success', 'Password successfully updated.');
            return redirect('/change_password');
        }
    }
}
