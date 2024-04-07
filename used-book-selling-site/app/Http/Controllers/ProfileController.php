<?php

namespace App\Http\Controllers;

use App\Models\Listing;

class ProfileController extends Controller
{
    public function show($name = null) {

        if (auth()->check()) {
            $name = $name ?? auth()->user()->name;
            return view('profile', ['name' => $name]);
        } else {
            return redirect()->route('login');
        }
    }
}
