<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SourceCtrl;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Session;
use App\Models\Student;
use Auth;


class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function contactCheck(Request $request)
    {
        $source = new SourceCtrl;

        $this->Validate($request, [
            'contact' => 'required|string|min:11|max:11'
        ]);

        $contact = '88'.$request->contact;
        $otp = rand(1111, 9999);
        $sms = 'Contact verification. Your OTP: '.$otp.' Live Education BD';
        Session::put('_otp', ['contact' => $request->contact, 'otp' => $otp]);
        $result = $source->sms_send($contact, $sms);
        
        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }

    public function otpCheck(Request $request)
    {
        $this->Validate($request, [
            'otp' => 'required|string|min:4|max:6'
        ]);

        $otp = Session::get('_otp');
        if($otp['otp'] == $request->otp)
        {
            try {
                Student::where('id', Auth::guard('student')->id())->update([
                    'contact' => $otp['contact'],
                    'contact_verify' => 'Yes'
                ]);
            }
            catch(\Exception $e){
                return $e->getMessage();

            }
        
            Session::forget('_otp');
    
            return response()->json([
                'success' => true,
                'message' => 'Contact successfully updated' 
            ]);
            
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'OTP does not match please check again.'
                ]);
        }
    }
}
