<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Listing;
use App\Models\Order;
use App\Models\Sold;
use App\Models\TempAddress;
use App\Models\UserAddress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function addToBasket(Request $request, $listingId) {

        $existingBasketItem = Basket::where('user_id', auth()->id())->where('listing_id', $listingId)->exists();

        if($existingBasketItem) {
            if($request->has('buyNow')){
                return redirect()->route('basket');
            } else {
                return redirect()->back()->with('success', 'Listing is already in your basket');
            }   
        } else {
            Basket::create([
                'user_id' => auth()->id(),
                'listing_id' => $listingId,
                'quantity' => 1,
            ]);
        }

        if($request->has('buyNow')) {
            return redirect()->route('basket');
        } else {
            return redirect()->back()->with('success', 'Listing added to your basket');
        }
    }

    public function removeFromBasket($listingId) {
        $basketItem = Basket::where('user_id', auth()->id())->where('listing_id', $listingId)->first();

        $basketItem->delete();
        
        return redirect()->back()->with('success', 'Listing removed from your basket');
    }

    public function checkout() {

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $basketItems = Basket::where('user_id', auth()->id())->get();

        $items = [];
        $totalPrice = 0;
        
        foreach($basketItems as $item) {
            $listing = Listing::find($item->listing_id);

            if($listing) {
                $totalPrice += $listing->listingPrice * $item->quantity;

                $imageUrl = asset('listingImages/' . $listing->listingImage);

                $items [] = [
                    'price_data' => [
                        'currency' => 'gbp',
                        'product_data' => [
                            'name' => $listing->listingTitle,
                            'images' => [$imageUrl]
                        ],
                        'unit_amount' => $listing->listingPrice * 100,
                      ],
                      'quantity' => $item->quantity
                ];
            }
        }

        $session = \Stripe\Checkout\Session::create([
            'line_items' => $items,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true)."?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout.cancel', [], true),
        ]);

        $order = new Order();
        $order->userId = auth()->id();
        $order->status = 'Processing payment';
        $order->total_price = $totalPrice;
        $order->session_id = $session->id;

        $order->save();

        return redirect($session->url);
    }
    
    
    public function success(Request $request) {
        
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $sessionId = $request->get('session_id');

        try{
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            if(!$session) {
                throw new NotFoundHttpException;
            }

            $order = Order::where('session_id', $sessionId)->firstOrFail();

            $userId = auth()->id(); // buyers ID
            
            $basketItems = Basket::where('user_id', $userId)->get();

            $address = TempAddress::where('user_id', $userId)->latest('created_at')->first() ?: UserAddress::where('user_id', $userId)->where('is_primary', true)->first();

            DB::transaction(function() use ($basketItems, $userId, $order, $sessionId) {
                foreach ($basketItems as $item) {
                    $listing = Listing::find($item->listing_id);

                    if ($listing) {
                        Sold::create([
                            'buyer_id' => $userId,
                            'seller_id' => $listing->userID,
                            'listing_id' => $listing->listingID,
                            'listing_title' => $listing->listingTitle,
                            'listing_author' => $listing->listingAuthor,
                            'listing_description' => $listing->listingDescription,
                            'isbn' => $listing->ISBN,
                            'listing_condition' => $listing->listingCondition,
                            'listing_price' => $listing->listingPrice,
                            'listing_image' => $listing->listingImage,
                            'orderID' => $order->id,
                        ]);

                        $listing->delete();
                    }
                }
            }); 
            
        } catch(Exception $e) {
            Log::error($e->getMessage());
            throw new NotFoundHttpException;
        }
        return view('checkoutSuccess', ['order' => $order, 'address' => $address]);
    }

    public function cancel() {
        return redirect()->back()->with('error', 'Payment cancelled');
    }
}
