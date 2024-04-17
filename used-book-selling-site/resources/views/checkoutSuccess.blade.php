@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/checkSuc.css') }}">
@endsection

@section('content')

<div class="container">

    <h1 class="confirmation-heading">Order confirmation page</h1>

    @if (isset($order))
        <p class="confirmation-message">Thank you for your order!</p>
        <p class="order-info">Order Number: B4S - {{ $order->id }}</p>
        <p class="order-info">Total Paid: £{{ $order->total_price }}</p>
        
        <h3 class="items-heading">Items:</h3>
        <ul class="items-list">
            @foreach ($order->soldItems as $soldItem)
                <li>{{ $soldItem->listing_title }} - £{{ $soldItem->listing_price }}</li>
            @endforeach
        </ul>

        @if(isset($address))
            <div class="delivery-address">
                <h3 class="address-heading">Order will be shipped to this address:</h3>
                <p class="address-info">{{ $address->address }}</p>
                <p class="address-info">{{ $address->city }}, {{ $address->zip }}</p>
            </div>
            <div class="delivery-estimate">
                <p class="estimate-message">You will receive your order in 2-3 working days.</p>
            </div>
        @endif

        <div class="order-status-link">
            <a href="{{ route('profile.orderHistory') }}">
                <button class="view-status">View status of order</button>
            </a>
        </div>
    @else
        <p class="error-message">Order information could not be found.</p>
    @endif

</div>

@endsection
