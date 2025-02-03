<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SourceCtrl;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\Student;
use Session;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function emailPassword(Request $request)
    {
        $source = new SourceCtrl;
        $request->validate(['email' => 'required|email']);
 
        // $status = Password::sendResetLink(
        //     $request->only('email')
        // );
    
        // return $status === Password::ResetLinkSent
        //             ? back()->with(['status' => __($status)])
        //             : back()->withErrors(['email' => __($status)]);

        $token = ucwords(md5(123));

        $user = Student::where('email', $request->email)->first();
        try{

            Student::where('email', $request->email)->update(['remember_token' => $token]);

            $emailData = [
                'email_to' => $user->email,
                'subject' => 'Reset-Password | Live Education BD',
                'comments' => 'Hello '.$user->name.',<br> Reset your password on clicking below link. <a target="_blank" href="'.$source->host().'/reset-password/'.$token.'">'.$source->host().'/reset-password/'.$token.'</a> Otherwise, browse the URL. '
            ];
    
            $source->sendMail($emailData);

        }
        catch(\Exception $e)
        {
            return $e;
        }

        Session::flash('success', 'An email sent to your email account '.$user->email.'. Please check your email.');
        return redirect()->route('homepage');
        
    }

    public function passwordReset($token)
    {
        $student = Student::where('remember_token', $token)->first();
        if($student)
        {
            return view('auth.passwords.reset', ['token' => $token]);
        }

        Session::flash('error', 'The token does not match.');
        return redirect()->route('homepage');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:32|confirmed',
        ]);

        try{
            Student::where('email', $request->email)->where('token', $request->token)->update(['password' => bcrypt($request->password)]);

            Session::flash('success', 'Password successfully updated');
            return redirect()->route('students.login');
        }
        catch(\Exception $e)
        {
            return $e;
        }

        return redirect()->route('homepage');

    }
}
