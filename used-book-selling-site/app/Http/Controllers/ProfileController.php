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
}
