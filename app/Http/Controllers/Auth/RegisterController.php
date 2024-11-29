<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SourceCtrl;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Models\Student;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->roles()->attach(Role::where('name', 'employee')->first());
        return $user;
    }

    public function signup()
    {
        return view('auth.register');
    }

    public function signupPost(Request $request)
    {
        $source = new SourceCtrl;

        $this->Validate($request, [
            'name'     => 'required|string|max:32|min:3',
            'email'    => 'required|email|max:32|min:8|unique:students',
            'contact'  => 'required|string|unique:students|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9|max:14',
            'password' => 'required|string|max:32|min:8'
        ]);

        $data = $request->all();
        
        if(isset($data['_token']))
        {
            unset($data['_token']);
        }

        $data['password'] = bcrypt($data['password']);
        $data['remember_token'] = ucwords(md5($data['contact']));
        $data['status'] = NULL;
        
        try{
            Student::insert($data);
        }
        catch(\E $e)
        {
            return $e;
        }

        $emailData = [
            'email_to' => $data['email'],
            'subject' => 'Email Verification | Sign Up at Live Education BD',
            'comments' => 'Hello '.$data['name'].',<br> Your email verification link below. On click the link verify your account. <a target="_blank" href="'.$source->host().'/account_verify/'.$data['remember_token'].'">Click Here</a>'
        ];

        $source->sendMail($emailData);

        Session::flash('success', 'Registration completed successfully. Thank you for joining us! A verification email has been sent to '.$data['email'].'. Please verify your account. If you encounter any issues during the verification process, feel free to contact our support team.');

        return redirect()->route('register');
    }

    public function verify($code)
    {
        $student = Student::where('remember_token', $code)
        ->where('status', NULL)
        ->first();

        if($student)
        {
            try{
                Student::where('id', $student->id)->update([
                    'status' => 'Active',
                    'remember_token' => NULL
                ]);
            }
            catch(\E $e)
            {
                return $e;
            }

            Session::flash('success', 'Your account successfully verified.');
        }
        else
        {
            Session::flash('error', 'Your account already verified.');
        }

        return redirect()->route('login');
    }
}
