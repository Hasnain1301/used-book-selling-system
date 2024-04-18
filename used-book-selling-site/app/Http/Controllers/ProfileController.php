<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Order;
use App\Models\Sold;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show($name = null) {

        if (auth()->check()) {
            $name = $name ?? auth()->user()->name;
            $user = auth()->user(); 
            $addresses = $user->addresses;  

            $notificationsCount = Order::whereHas('soldItems', function ($query) use ($user) {
                $query->where('seller_id', $user->id);
            })->where('status', 'Cancelled')->count();
    

            return view('profile', ['name' => $name, 'addresses' => $addresses, 'notificationsCount' => $notificationsCount]);
        } else {
            return redirect()->route('login');
        }
    }

    public function showOrderHistory() {
        $user = auth()->user();
        $orders = Order::where('userId', $user->id)->get();

        $notificationsCount = Order::whereHas('soldItems', function ($query) use ($user) {
            $query->where('seller_id', $user->id);
        })->where('status', 'Cancelled')->count();

        $respondedReturnsCount = Order::whereHas('soldItems', function ($query) use ($user) {
            $query->where('userId', $user->id);
        })->whereIn('return_status', ['Approved', 'Denied'])->count();

        return view('orderHistory', [
            'orders' => $orders,
            'notificationsCount' => $notificationsCount,
            'respondedReturnsCount' => $respondedReturnsCount
        ]);
    }

    public function showSoldBooks() {
        $user = auth()->user();
        $soldBooks = Sold::where('seller_id', $user->id)->get();

        $notificationsCount = Order::whereHas('soldItems', function ($query) use ($user) {
            $query->where('seller_id', $user->id);
        })->where('status', 'Cancelled')->count();
        
        $requestedReturnsCount = Order::whereHas('soldItems', function ($query) use ($user) {
            $query->where('seller_id', $user->id);
        })->where('return_status', 'Requested')->count();


        return view('soldBooks', [
            'soldBooks' => $soldBooks,
            'notificationsCount' => $notificationsCount,
            'requestedReturnsCount' => $requestedReturnsCount
        ]);
    }

    public function completeOrder($soldBookId) {
        $soldBook = Sold::with('order')->findOrFail($soldBookId); 
        $order = $soldBook->order;
    
        if ($order->status === 'Dispatching') { 
            $order->status = 'Delivered';
            $order->save();
    
            return back()->with('status', 'Order marked as delivered!');
        }
    
        return back()->with('error', 'Order is not in Dispatching status.');
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
            'department' => $soldItem->department,
            'year' => $soldItem->year
        ]);
        $listing->save();

        $soldItem->delete();

        return back()->with('success', 'Item relisted successfully.');
    }

    public function returnForm($orderId) {
        $order = Order::with('soldItems')->find($orderId);

        if (!$order || $order->userId !== auth()->id() || $order->status !== 'Delivered') {
            abort(404);
        }
    
        return view('returnForm', ['order' => $order]);
    }

    public function requestReturn(Request $request, $orderId) {
        $order = Order::find($orderId);
    
        if ($order && $order->userId === auth()->id() && $order->status === 'Delivered') {
            $order->requestReturn($request->input('return_reason'));
    
            return back()->with('success', 'Return requested successfully.');
        }
        return back()->with('error', 'Return request unsuccessful.');
    }

    public function submitReturnRequest(Request $request, $orderId) {
        $order = Order::find($orderId);
    
        if (!$order || $order->userId !== auth()->id() || $order->status !== 'Delivered') {
            abort(404); 
        }
    
        $order->return_status = 'Requested';
        $order->return_reason = $request->input('return_reason');
        $order->save();
        
        return view('returnForm', ['order' => $order])->with('success', 'Return requested successfully.');
    }

    public function viewReturnRequest($orderId){
        $order = Order::with('soldItems')->findOrFail($orderId);
        $primaryAddress = UserAddress::where('user_id', auth()->id())->where('is_primary', true)->first();

        $soldItem = $order->soldItems->first();
        if($soldItem->seller_id !== auth()->id()) {
            abort(404);
        }

        return view('viewReturnRequest', ['order' => $order, 'primaryAddress' => $primaryAddress]);
    }

    public function acceptReturnRequest($orderId){
        $order = Order::findOrFail($orderId);
        $userAddress = UserAddress::where('user_id', $order->userId)->where('is_primary', true)->first();

        if ($userAddress) {
            $addressString = "Door/Flat no: " . $userAddress->flat_number . ", Address: " . $userAddress->address . ", City: " . $userAddress->city . ", ZIP: " . $userAddress->zip;
            $order->seller_message = $addressString;
        }
        
        $order->return_status = 'Approved';

        $order->save();

        return back()->with('success', 'Accepted return request.');
    }

    public function rejectReturnRequest(Request $request, $orderId){
        $order = Order::findOrFail($orderId);

        $reason = $request->input('rejection_reason'); 
        $order->seller_message = $reason;
        $order->return_status = 'Denied';

        $order->save();

        return back()->with('success', 'Rejected return request.');
    }
}
