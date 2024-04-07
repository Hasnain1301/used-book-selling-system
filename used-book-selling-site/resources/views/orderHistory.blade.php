@extends('layouts.base')

@section('content')

<div class="container">
    <h1>Order history</h1>

    <div class="profile-navigation">
        <ul style="list-style: none; padding: 0; display: flex; justify-content: space-evenly;">
            <li><a href="{{ route('profile') }}">Personal Details</a></li>
            <li><a href="{{ route('profile.orderHistory') }}">Order History</a></li>
            <li><a href="{{ route('profile.soldBooks') }}">Sold Books</a></li>
        </ul>
    </div>

    <div class="row mb-4">
        <div class="col">
            <h2>Order History</h2>
            @if($orders->isEmpty())
                <p>You have no orders.</p>
            @else
                <ul>
                    @foreach($orders as $order)
                        <li>
                            Order #{{ $order->id }} - {{ $order->created_at->toFormattedDateString() }} - Status of order: {{ $order->status }}         
                            <a href="{{ route('profile.orderDetails', $order->id) }}">View Order Details</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>


@endsection

<!--                         <ul>
                            @foreach($order->soldItems as $soldItem)
                                <li>{{ $soldItem->listing_title }} - {{ $soldItem->listing_price }}</li>
                            @endforeach
                        </ul> -->

