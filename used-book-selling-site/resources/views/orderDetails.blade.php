@extends('layouts.base')

@section('content')

    <h1>Order #B4S-{{ $order->id }} Details</h1>

    <p>Date of order: {{ $order->created_at->toFormattedDateString() }}</p>

    <p>Status of your order:</p>

    <div class="progress">
        <div class="progress-bar" role="progressbar" 
                style="width: {{ $order->status == 'Delivered' ? '100%' : ($order->status == 'Dispatching' ? '66%' : '33%') }}"
                aria-valuenow="{{ $order->status == 'Delivered' ? '3' : ($order->status == 'Dispatching' ? '2' : '1') }}" 
                aria-valuemin="0" 
                aria-valuemax="3">
        </div>
    </div>

    <div class="status-steps">
        <span class="{{ $order->status != 'Processing' ? 'active' : '' }}">1. Order Paid For</span>
        <span class="{{ $order->status == 'Dispatching' || $order->status == 'Delivered' ? 'active' : '' }}">2. Dispatching</span>
        <span class="{{ $order->status == 'Delivered' ? 'active' : '' }}">3. Delivered</span>
    </div>

    <h2>Items in this order:</h2>
    <ul>
        @foreach($order->soldItems as $item)
            <li><img src="{{ $item->listing_image }}" alt="" style="width:250px; height:auto;"> {{ $item->listing_title }} - £{{ $item->listing_price }}</li>
        @endforeach
    </ul>

    <h3><a href="{{ route('profile.orderHistory') }}">Back to all orders</a></h3>

@endsection

<style>
    .progress {
        background-color: #e0e0e0;
        border-radius: 5px;
        height: 20px;
        width: 100%;
        margin-bottom: 10px;
    }

    .progress-bar {
        background-color: #4CAF50; /* Green color */
        height: 100%;
        transition: width 0.4s ease;
    }

    .status-steps {
        display: flex;
        justify-content: space-between;
        list-style-type: none;
        padding: 0;
    }

    .status-steps span {
        flex: 1;
        text-align: center;
        font-weight: normal;
        color: #aaa;
    }

    .status-steps span.active {
        font-weight: bold;
        color: #333;
    }
</style>
