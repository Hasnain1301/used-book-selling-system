<?php

namespace App\Http\Controllers;

use App\Models\Listing;

class ProfileController extends Controller
{
    public function show($name = null) {

        if (auth()->check()) {
            $name = $name ?? auth()->user()->name;

            $user = auth()->user();
            $listings = Listing::where('userID', $user->id)->get();

            return view('profile', ['user' => $user, 'listings' => $listings]);
        } else {
            return redirect()->route('login');
        }
    }
}
