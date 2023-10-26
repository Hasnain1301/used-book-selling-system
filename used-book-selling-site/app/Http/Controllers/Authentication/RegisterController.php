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
            'password' => 'required|confirmed',
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
        return redirect()->route('home');
    }
}
