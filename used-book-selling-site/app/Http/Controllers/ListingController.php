<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function create() {
        return view('create');
    }

    public function showListing(Listing $listing) {
        return view('individualListing', ['listing' => $listing]);
    }

    public function add(Request $request) {

        $request->validate([
            'listingTitle' => 'required|string',
            'listingAuthor' => 'required|string',
            'listingDescription' => 'required|string',
            'ISBN' => 'required|numeric',
            'listingCondition' => 'required|string',
            'listingPrice' => 'required|numeric',
            'listingImage' => 'required|image',
            'department' => 'required|string',
            'year' => 'required|string',
        ], [
            'ISBN.required' => 'The ISBN field is required.',
            'ISBN.numeric' => 'The ISBN must be a number'
        ]);

        $listing = new Listing();

        $listing->listingTitle = request('listingTitle');
        $listing->userId = auth()->user()->id;
        $listing->listingAuthor = request('listingAuthor');
        $listing->listingDescription = request('listingDescription');
        $listing->ISBN = request('ISBN');
        $listing->listingCondition = request('listingCondition');
        $listing->listingPrice = request('listingPrice');
        $listing->department = $request->input('department');
        $listing->year = $request->input('year');
        
        if($request->hasFile('listingImage')){
            $image = $request->file('listingImage');
            $filename = time().'_'.$image->getClientOriginalName();
            $image->move('listingImages', $filename);
            $listing->listingImage = '/listingImages/'.$filename;
        }
        
        $listing->save();

        return redirect()->route('manage.listings', ['name' => auth()->user()->name])->with('added', "Listing added sucessfully");
    }

    public function delete(Listing $listing) {
        $listing->delete();

        return back()->with('delete', "Listing deleted successfully");
    }

    public function edit(Listing $listing) {
        return view('edit', ['listing' => $listing]);
    }

    public function update($listingID, Request $request) {

        $request->validate([
            'listingTitle' => 'required|string',
            'listingAuthor' => 'required|string',
            'listingDescription' => 'required|string',
            'ISBN' => 'required|numeric',
            'listingCondition' => 'required|string',
            'listingPrice' => 'required|numeric',
            'listingImage' => $request->hasFile('listingImage') ? 'required|image' : '',
            'department' => 'required|string',
            'year' => 'required|string',
        ], [
            'ISBN.required' => 'The ISBN field is required.',
            'ISBN.numeric' => 'The ISBN must be a number'
        ]);

        $editListing = Listing::FindOrFail($listingID);

        $editListing->listingTitle = request('listingTitle');
        $editListing->listingAuthor = request('listingAuthor');
        $editListing->listingDescription = request('listingDescription');
        $editListing->ISBN = request('ISBN');
        $editListing->listingCondition = request('listingCondition');
        $editListing->listingPrice = request('listingPrice');
        $editListing->department = $request->input('department');
        $editListing->year = $request->input('year');
        
        if($request->hasFile('listingImage')){
            $image = $request->file('listingImage');
            $filename = time().'_'.$image->getClientOriginalName();
            $image->move('listingImages', $filename);
            $editListing->listingImage = '/listingImages/'.$filename;
        }
        
        $editListing->save();

        return redirect()->route('manage.listings', ['name' => auth()->user()->name]);
    }

    public function manageListings() {
        if (auth()->check()) {
            $name = $name ?? auth()->user()->name;

            $user = auth()->user();
            $listings = Listing::where('userID', $user->id)->get();

            return view('manageListings', ['user' => $user, 'listings' => $listings]);
        } else {
            return redirect()->route('login');
        }
    }
}
