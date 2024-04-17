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

        if ($departments = $request->input('departments')) {
            $query->whereIn('department', $departments);
        }

        if ($years = $request->input('years')) {
            $query->whereIn('year', $years);
        }

        if ($conditions = $request->input('conditions')) {
            $query->whereIn('listingCondition', $conditions);
        }
    
        $listings = $query->get();

        $departments = [
            'Aston Business School',
            'Aston Law School',
            'Aston Medical School',
            'Health and Life Sciences',
            'College of Engineering and Physical Sciences',
            'College of Business and Social Sciences',
            'School of Social Sciences and Humanities'
        ];

        $years = ['first', 'second', 'third', 'fourth', 'fifth'];
        $conditions = ['excellent', 'good', 'fair', 'poor'];

        return view('home', [
            'listings' => $listings,
            'selectedDepartments' => $request->input('departments', []),
            'selectedYears' => $request->input('years', []),
            'selectedConditions' => $request->input('conditions', []),
            'departments' => $departments,
            'years' => $years,
            'conditions' => $conditions,
        ]);
    }      
}
