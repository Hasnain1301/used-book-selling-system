<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index() {
        return view('authentication.login');
    }

    public function login(Request $request) {
        
        //validate what is entered into the form
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(!auth()->attempt(['email' => $request->email, 'password' => $request->password,])) {
            return back()->with('incorrect', 'Incorrect email or password');
        }   

        return redirect()->route('home')->with('success', 'You have been signed in');
    }
}
