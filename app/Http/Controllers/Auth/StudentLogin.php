<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Student;
use Session;

class StudentLogin extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/students';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        return view('auth.student-login');
    }

    public function loginPost(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|max:32'
        ]);

        // $user = Student::where('email', $request->email)->first();
        // if($user->status != 'Active')
        // {
        //     Session::flash('error', 'Please check your email and verify the account.');
        //     return back();
        // }

        $email    = $request->email;
        $password = $request->password;

        if(Auth::guard('student')->attempt([
            'email' => $email,
            'password' => $password,
            // 'status' => 'Active'
        ], $remember = true))
        {
            return redirect()->intended(route('students.my-course'));
        }
        // else
        // {
        //     Session::flash('error', 'Invalid Credentials!');
        // }
        // return redirect()->route('students.login');
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('student')->logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect()->route('students.login');
    }
}
