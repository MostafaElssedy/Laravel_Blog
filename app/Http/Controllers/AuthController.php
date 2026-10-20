<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordCheckRequest;
use App\Http\Requests\ResetPasswordProcessRequest;
use App\Models\User;
use App\UserType;
use App\UserStatus;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request){
        $data = [
            'pageTitle'=>'Login'
        ];
        return view('Back.Pages.auth.login',$data);
    }
    public function forgot(Request $request){
        $data = [
            'pageTitle'=>'Forgot Password'
        ];
        return view('Back.Pages.auth.forgot',$data);
    }  
    public function loginProcess(LoginRequest $request){
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $creds = [$fieldType => $request->login_id, 'password' => $request->password];

        if(Auth::attempt($creds)){
            //Check if account is inactive mode
            if( auth()->user()->status === UserStatus::Inactive ){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->with('fail','Your account is currently inactive. Please, contact support at (support@larablog.test) for further assistance.');
            }

            //Check if account is in Pending mode
            if( auth()->user()->status === UserStatus::Pending ){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->with('fail','Your account is currently pending approval. Please, check your email for further instructions or contact support at (support@larablog.test) assistance.');
            }

            // Check if the user is an admin or super admin
            if(auth()->user()->type === UserType::Admin || auth()->user()->type === UserType::SuperAdmin){
                return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully.');
            }

            // If a normal user tries to login from admin portal
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login')->with('fail', 'You do not have permission to access this area.');
            
        }else{
            return redirect()->route('admin.login')->withInput()->with('fail', 'Incorrect password.');
        }
    }
    public function sendPasswordResetLink(ForgotPasswordRequest $request){
        $user = User::where('email', $request->email)->first();
        $token = \Illuminate\Support\Str::random(64);

        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => \Carbon\Carbon::now()]
        );

        $actionLink = route('admin.resetPassword', ['token' => $token, 'email' => $request->email]);

        $mailConfig = [
            'recipient_address' => $request->email,
            'recipient_name'    => $user->name,
            'subject'           => 'Reset Password',
            'body'              => view('email-templates.forgot-password', [
                                        'user' => $user, 
                                        'actionLink' => $actionLink
                                   ])->render()
        ];

        $isSent = \App\Helpers\CMail::send($mailConfig);

        if($isSent){
            return back()->with('success', 'We have e-mailed your password reset link!');
        } else {
            return back()->with('fail', 'Something went wrong. Please try again later.');
        }
    }

    public function resetPassword(ResetPasswordCheckRequest $request, $token){
        $checkToken = \Illuminate\Support\Facades\DB::table('password_reset_tokens')
                        ->where('email', $request->email)
                        ->where('token', $token)
                        ->first();

        if(!$checkToken){
            return redirect()->route('admin.forgot')->with('fail', 'Invalid token. Request another reset link.');
        } else {
            // Check if token is expired (e.g., older than 15 minutes)
            $tokenAge = \Carbon\Carbon::parse($checkToken->created_at)->diffInMinutes(\Carbon\Carbon::now());
            if($tokenAge > 15){
                return redirect()->route('admin.forgot')->with('fail', 'This password reset link has expired. Please request a new one.');
            }
        }

        return view('Back.Pages.auth.reset', ['token' => $token]);
    }

    public function resetPasswordProcess(ResetPasswordProcessRequest $request){
        $checkToken = \Illuminate\Support\Facades\DB::table('password_reset_tokens')
                        ->where('email', $request->email)
                        ->where('token', $request->token)
                        ->first();

        if(!$checkToken){
            return redirect()->route('admin.forgot')->with('fail', 'Invalid token. Request another reset link.');
        } else {
            // Check if token is expired
            $tokenAge = \Carbon\Carbon::parse($checkToken->created_at)->diffInMinutes(\Carbon\Carbon::now());
            if($tokenAge > 15){
                return redirect()->route('admin.forgot')->with('fail', 'This password reset link has expired. Please request a new one.');
            }
        }

        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->new_password)
        ]);

        \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        // Send confirmation email
        $mailConfig = [
            'recipient_address' => $user->email,
            'recipient_name'    => $user->name,
            'subject'           => 'Password Changed Successfully',
            'body'              => view('email-templates.password-changed', ['user' => $user])->render()
        ];
        \App\Helpers\CMail::send($mailConfig);

        return redirect()->route('admin.login')->with('success', 'Your password has been changed successfully. You can login now.');
    }
}
