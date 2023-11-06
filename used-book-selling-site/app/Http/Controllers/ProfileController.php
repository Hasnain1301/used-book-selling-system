<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show($name = null) {

        $name = $name ?? auth()->user()->name;

        return view('profile');
    }
}
