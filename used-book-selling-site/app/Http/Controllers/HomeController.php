<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request) {
        $query = Listing::query();
    
        if ($search = $request->input('search')) {
            $query->where('listingTitle', 'like', "%{$search}%")
                  ->orWhere('listingAuthor', 'like', "%{$search}%")
                  ->orWhere('listingDescription', 'like', "%{$search}%")
                  ->orWhere('ISBN', 'like', "%{$search}%");
        }
    
        $listings = $query->get();
    
        return view('home', ['listings' => $listings]);
    }    
}
