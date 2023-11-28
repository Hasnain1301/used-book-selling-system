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

            $totalPrice += $listing->listingPrice;
        }
        
        return view('basket', ['basketItems' => $basketItems, 'totalPrice' => $totalPrice]);
    }

    public function addToBasket($listingId) {

        $existingBasketItem = Basket::where('user_id', auth()->id())->where('listing_id', $listingId)->exists();

        if($existingBasketItem) {
            return redirect()->back()->with('success', 'Listing is already in your basket');
        } else {
            Basket::create([
                'user_id' => auth()->id(),
                'listing_id' => $listingId,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Listing added to your basket');
    }

    public function removeFromBasket($listingId) {
        $basketItem = Basket::where('user_id', auth()->id())->where('listing_id', $listingId)->first();

        $basketItem->delete();
        
        return redirect()->back()->with('success', 'Listing removed from your basket');
    }
}
