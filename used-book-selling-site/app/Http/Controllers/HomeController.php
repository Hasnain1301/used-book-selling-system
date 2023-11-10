<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {

        $lisitings = Listing::all();

        return view('home', ['listings' => $lisitings]);
    }
}
