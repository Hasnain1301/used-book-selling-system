<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index() {
        return view('authentication.register');
    }

    public function save(Request $request) {

        //validate inputs from form
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                'min:8', // minimum 8 characters
                'regex:/[A-Z]/', // at least one uppercase letter
                'regex:/[@$!%*#?&-_]/', // at least one special character
            ],[
                'password.min' => 'The password must be at least 8 characters long.',
                'password.regex' => 'The password must contain at least one uppercase letter and one special character.',
            ]
        ]);

        //create account and add to database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //after registering, user is signed in
        auth()->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        //redirect back to home page once registered
        return redirect()->route('home')->with('registered','Your account has been successfully registered');
    }
}
