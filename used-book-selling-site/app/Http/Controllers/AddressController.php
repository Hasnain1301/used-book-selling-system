<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Listing;
use App\Models\TempAddress;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
{

    public function show(){

        $userId = auth()->id();

        $addresses = UserAddress::where('user_id', $userId)->get();
        $primaryAddress = UserAddress::where('user_id', $userId)->where('is_primary', true)->first();

        return view('orderAddress', ['addresses' => $addresses, 'primaryAddress' => $primaryAddress]);
    }

    public function saveAddress(Request $request){
        $validatedData = $request->validate([
            'address' => 'required|string|max:255',
            'flat_number' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'is_primary' => 'nullable|boolean',
        ]);

        if ($request->has('is_primary') && $request->input('is_primary')) {
            UserAddress::where('user_id', auth()->id())->update(['is_primary' => false]);
    
            $validatedData['is_primary'] = true;
            UserAddress::create($validatedData + ['user_id' => auth()->id()]);

            $data = $this->getSharedData();

            return view('paymentChoose', $data)->with('success', 'Your address has been saved.');

        } else {
            $tempAddress = TempAddress::create($validatedData + ['user_id' => auth()->id()]);

            $data = $this->getSharedData();

            return view('paymentChoose', ['tempAddress' => $tempAddress], $data);
        }
    }

    public function setPrimaryAddress(Request $request){
        $validatedData = $request->validate([
            'address_id' => 'required|integer|exists:user_addresses,id',
        ]);

        UserAddress::where('user_id', auth()->id())->update(['is_primary' => false]);

        UserAddress::where('id', $validatedData['address_id'])->update(['is_primary' => true]);

        return back()->with('success', 'Primary address has been updated.');
    }

    public function delete(UserAddress $address){
        if ($address->user_id != auth()->id()) {
            abort(403);
        }

        $address->delete();

        return back()->with('success', 'Address deleted successfully.');
    }

    public function usePrimaryAddress(Request $request){
        $primaryAddressId = $request->input('primary_address_id');
        
        $primaryAddress = UserAddress::find($primaryAddressId);

        $data = $this->getSharedData();
        
        return view('paymentChoose', ['primaryAddress' => $primaryAddress], $data);
    }

    public function showPaymentOptions() {
    
        $data = $this->getSharedData();

        return view('paymentChoose', $data);
    }
    
    //method for shared data
    private function getSharedData() {
        $user = auth()->user();
        $userId = $user->id;

        $primaryAddress = UserAddress::where('user_id', $userId)->where('is_primary', true)->first();
        $tempAddress = TempAddress::where('user_id', $userId)->latest()->first();

        $basketItems = Basket::where('user_id', $userId)->get();

        $totalPrice = 0;
        foreach ($basketItems as $basketItem) {
            $listing = Listing::find($basketItem->listing_id);
            if ($listing) {
                $basketItem->listingTitle = $listing->listingTitle;
                $basketItem->listingAuthor = $listing->listingAuthor;
                $basketItem->listingImage = $listing->listingImage;
                $basketItem->listingPrice = $listing->listingPrice;
                $totalPrice += $basketItem->quantity * $listing->listingPrice;
                $basketItem->department = $listing->department;
                $basketItem->year = $listing->year;
            }
        }
    
        return [
            'user' => $user,
            'primaryAddress' => $primaryAddress,
            'tempAddress' => $tempAddress,
            'basketItems' => $basketItems,
            'totalPrice' => $totalPrice,
        ];
    }
}
