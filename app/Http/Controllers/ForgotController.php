<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;



class ForgotController extends Controller
{
    public function forgotPasswordLoad()
    {
        return view('forgot');
    }
    public function resetPasswordLoad($token)
    {
        $user = User::where('remember_token', '=', $token)->first();
        if (!empty($user)) {
            $data['user'] = $user;
            return view('resetPassword', $data, ['token' => $token]);
        } else {
            abort(404);
        }
    }

    public function resetPassword($token, Request $request)
    {
        $user = User::where('remember_token', '=', $token)->first();
        if (!empty($user)) {
            if ($request->password == $request->password_confirmation) {
                $user->password = Hash::make($request->password);
                if (empty($user->email_verified_at)) {
                    $user->email_verified_at = date('Y-m-d H:i:s');
                }
                $user->remember_token = Str::random(40);
                $user->save();
                return redirect('login')->with('message', "Password successfully reset.");
            } else {
                return redirect()->back()->with('error', "Password and Confirm Password does not match");
            }
        } else {
            abort(404);
        }
    }

    public function forgotPassword(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if (!empty($user)) {
            $user->remember_token = Str::random(40);
            $user->save();

            Mail::to($user->email)->send(new ForgotPasswordMail($user));

            return redirect()->back()->with('message', 'Please check your email and reset your password.');
        } else {
            return redirect()->back()->with('error', 'Email not found in the System');
        }
    }
}
