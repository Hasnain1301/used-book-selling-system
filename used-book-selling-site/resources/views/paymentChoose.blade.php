@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
@endsection

@section('content')

<div class="user-info">
    <p class="user-detail"><strong>Buyer:</strong> {{ $user->name }}</p>
    @if($primaryAddress)
        <p class="address-detail"><strong>Delivery Address:</strong> {{ $primaryAddress->flat_number }} {{ $primaryAddress->address }}, {{ $primaryAddress->city }}, {{ $primaryAddress->zip }}</p>
    @elseif($tempAddress)
        <p class="address-detail"><strong>Delivery Address:</strong> {{ $tempAddress->flat_number }} {{ $tempAddress->address }}, {{ $tempAddress->city }}, {{ $tempAddress->zip }}</p>
    @else
        <p class="no-address">No delivery address set.</p>
    @endif
</div>

@if($basketItems->isNotEmpty())
    <div class="basket-details">
        <h4>Item(s) you are purchasing:</h4>
        @foreach($basketItems as $item)
            <div class="item">
                <p><strong>Title:</strong> {{ $item->listingTitle }}</p>
                <p><strong>Author:</strong> {{ $item->listingAuthor }}</p>
                <p><strong>Price:</strong> £{{ $item->listingPrice }}</p>
            </div>
        @endforeach
        <p class="total-price"><strong>Total price to pay:</strong> £{{ $totalPrice }}</p>
    </div>
@else
    <p class="empty-basket">There is nothing to purchase.</p>
@endif


<div class="payment-form">
    <form action="{{ route('basket.checkout') }}" method="post">
        @csrf
        <button type="submit" class="pay-button">Pay now</button>
    </form>
</div>

@endsection
