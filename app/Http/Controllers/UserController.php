<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function signupsave(Request $request)
    {
        try {
            // Validation rules for user registration
            $validationRules = [
                'firstname'     => 'required|string|min:3|max:255',
                'lastname'      => 'required|string|min:3|max:255',
                'username'      => 'required|alpha_dash|unique:users|min:3|max:20',
                'email'         => 'required|email|unique:users',
                'mobile_number' => 'required|unique:users|digits_between:10,15',
                'password'      => 'required|confirmed|min:6',
            ];
            //validate the request
            $validator = Validator::make($request->all(), $validationRules);

            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            // Create a new user instance
            $user                = new User();
            $user->firstname     = $request->firstname;
            $user->lastname      = $request->lastname;
            $user->username      = $request->username;
            $user->email         = $request->email;
            $user->mobile_number = $request->mobile_number;
            $user->password      = Hash::make($request->password); // Encrypt the password
            $user->save();


            return Redirect::route('login')->with('message', 'Successully Registered');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return Redirect::back()->with('error', 'An error occurred while registering. Please try again.');
        }
    }
    public function login()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }
        return view('auth.login');
    }
    // Create a new user instance after a valid registration.
    public function create(array $data)
    {
        return user::create([

            'firstname'          => $data['firstname'],
            'lastname'           => $data['lastname'],
            'username'           => $data['username'],
            'email'              => $data['email'],
            'mobile_number'      => $data['mobile_number'],
            'password'           => Hash::make($data['password']),
            'confirm password'   => Hash::make($data['confirm password']),
        ]);
    }

    // Store a newly created user in storage.
    public function store(Request $request)
    {
        $user = new User();
        $user->firstname         = $request->firstname;
        $user->lastname          = $request->lastname;
        $user->username          = $request->username;
        $user->email             = $request->email;
        $user->mobile_number     = $request->mobile_number;
        $user->password          = $request->password;
        $user->confirm_password  = $request->password;
        $user->save();
    }
}
