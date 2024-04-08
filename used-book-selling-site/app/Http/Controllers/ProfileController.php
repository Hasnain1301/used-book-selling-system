<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Order;
use App\Models\Sold;
use App\Models\UserAddress;

class ProfileController extends Controller
{
    public function show($name = null) {

        if (auth()->check()) {
            $name = $name ?? auth()->user()->name;
            $user = auth()->user(); 
            $addresses = $user->addresses;  

            return view('profile', ['name' => $name, 'addresses' => $addresses]);
        } else {
            return redirect()->route('login');
        }
    }

    public function showOrderHistory() {
        $user = auth()->user();
        $orders = Order::where('userId', $user->id)->get();
        return view('orderHistory', [
            'orders' => $orders
        ]);
    }

    public function showSoldBooks() {
        $user = auth()->user();
        $soldBooks = Sold::where('seller_id', $user->id)->get();
        return view('soldBooks', [
            'soldBooks' => $soldBooks
        ]);
    }

    public function deleteAddress(UserAddress $address) {
        if (auth()->id() == $address->user_id) {
            $address->delete();
            return back()->with('success', 'Address deleted successfully.');
        }
    
        return back()->with('error', 'You do not have permission to delete this address.');
    }
    
    public function setPrimaryAddress(UserAddress $address) {
        if (auth()->id() == $address->user_id) {
            UserAddress::where('user_id', auth()->id())->update(['is_primary' => false]);

            $address->is_primary = true;
            $address->save();
    
            return back()->with('success', 'Primary address updated successfully.');
        }
    
        return back()->with('error', 'You do not have permission to set this address as primary.');
    }

    public function showOrderDetails($orderId) {
        $user = auth()->user();
        $order = Order::with('soldItems')->where('userId', $user->id)->where('id', $orderId)->firstOrFail();
    
        return view('orderDetails', [
            'order' => $order
        ]);
    }    

    public function cancel(Order $order){
        if ($order->canBeCancelled()) {
            $order->status = 'Cancelled';
            $order->save();

            return redirect()->back()->with('status', 'Order cancelled successfully.');
        }

        return redirect()->back()->with('error', 'Order cannot be cancelled.');
    }

    public function relistItem($soldBookId){
        $soldItem = Sold::findOrFail($soldBookId);

        if ($soldItem->seller_id != auth()->id()) {
            return back()->with('error', 'You cannot relist this item.');
        }

        $listing = new Listing([
            'userID' => auth()->id(),
            'listingTitle' => $soldItem->listing_title,
            'listingAuthor' => $soldItem->listing_author,
            'listingDescription' => $soldItem->listing_description,
            'ISBN' => $soldItem->isbn,
            'listingCondition' => $soldItem->listing_condition,
            'listingPrice' => $soldItem->listing_price,
            'listingImage' => $soldItem->listing_image,
        ]);
        $listing->save();

        $soldItem->delete();

        return back()->with('success', 'Item relisted successfully.');
    }
}
