@extends('layouts.base')

@section('content')

<h1>Order confirmation page</h1>

@if (isset($order))
    <p>Thank you for your order!</p>
    <p>Order Number: B4S - {{ $order->id }}</p>
    <p>Total Paid: £{{ $order->total_price }}</p>
    
    <h3>Items:</h3>
    <ul>
        @foreach ($order->soldItems as $soldItem)
            <li>{{ $soldItem->listing_title }} - £{{ $soldItem->listing_price }}</li>
        @endforeach
    </ul>

    @if(isset($address))
        <div class="delivery-address">
            <h3>Order will be shipped to this address:</h3>
            <p>{{ $address->address }}</p>
            <p>{{ $address->city }}, {{ $address->zip }}</p>
        </div>
        <div class="delivery-estimate">
            <p>You will receive your order in 2-3 working days.</p>
        </div>
    @endif

    
@else
    <p>Order information could not be found.</p>
@endif



@endsection
