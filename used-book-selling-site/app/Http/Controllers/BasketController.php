<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Listing;

class BasketController extends Controller
{
    public function show() {
        $basketItems = Basket::where('user_id', auth()->id())->get();

        $totalPrice = 0;

        foreach($basketItems as $basketItem) {
            $listing = Listing::find($basketItem->listing_id);

            $basketItem->listingTitle = $listing->listingTitle;
            $basketItem->listingAuthor = $listing->listingAuthor;
            $basketItem->listingImage = $listing->listingImage;
            $basketItem->listingPrice = $listing->listingPrice;

            $totalPrice += $listing->listingPrice * $basketItem->quantity;
        }
        
        return view('basket', ['basketItems' => $basketItems, 'totalPrice' => $totalPrice]);
    }

    public function addToBasket($listingId) {

        Basket::create([
            'user_id' => auth()->id(),
            'listing_id' => $listingId,
            'quantity' => 1,
        ]);

        return redirect()->back()->with('success', 'Listing added to your basket');
    }
}
