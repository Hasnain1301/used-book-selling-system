<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Order;
use App\Models\Sold;

class ProfileController extends Controller
{
    public function show($name = null) {

        if (auth()->check()) {
            $name = $name ?? auth()->user()->name;
            return view('profile', ['name' => $name]);
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
}
