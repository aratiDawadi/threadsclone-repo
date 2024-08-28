<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class HomeController extends Controller

{
    // * Display the homepage.
    public function home()
    {
        return view('homepage');
    }
    public function register()
    {

        if (Auth::check()) {
            return redirect('dashboard');
        }
        return view('auth.register');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect('login')->with('message', 'Successfully log out!');
    }
}
