<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout() {

        auth()->logout();

        return redirect()->route('home')->with('logout', 'You have been logged out');
    }
}
