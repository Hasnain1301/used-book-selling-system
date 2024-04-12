@extends('layouts.base')

@section('content')

    <h1>Order #B4S-{{ $order->id }} Details</h1>

    <p>Date of order: {{ $order->created_at->toFormattedDateString() }}</p>

    <p>Status of your order: {{ $order->status }}</p>

    <div class="progress" style="background-color: {{ $order->status == 'Cancelled' ? '#dc3545' : '#e0e0e0' }};">
        <div class="progress-bar" role="progressbar" 
            style="width: {{ $order->status == 'Cancelled' ? '100%' : ($order->status == 'Delivered' ? '100%' : ($order->status == 'Dispatching' ? '66%' : '33%')) }};
                   background-color: {{ $order->status == 'Cancelled' ? '#dc3545' : '#007bff' }};"
            aria-valuenow="{{ $order->status == 'Cancelled' ? '0' : ($order->status == 'Delivered' ? '3' : ($order->status == 'Dispatching' ? '2' : '1')) }}"
            aria-valuemin="0"
            aria-valuemax="3">
        </div>
    </div>

    <div class="status-steps">
        <span class="{{ $order->status == 'Cancelled' ? 'text-muted' : ($order->status != 'Processing' ? 'active' : '') }}">1. Order Paid For</span>
        <span class="{{ $order->status == 'Cancelled' ? 'text-muted' : ($order->status == 'Dispatching' || $order->status == 'Delivered' ? 'active' : '') }}">2. Dispatching</span>
        <span class="{{ $order->status == 'Cancelled' ? 'text-muted' : ($order->status == 'Delivered' ? 'active' : '') }}">3. Delivered</span>
    </div>

    <h2>Items in this order:</h2>
    <ul>
        @foreach($order->soldItems as $item)
            <li><img src="{{ $item->listing_image }}" alt="" style="width:250px; height:auto;"> {{ $item->listing_title }} - £{{ $item->listing_price }}</li>
        @endforeach
    </ul>

    @if($order->status == 'Delivered')
        @if($order->return_status == 'Requested')
            <button class="btn btn-secondary" disabled>Awaiting approval for return</button>
        @elseif($order->return_status == 'Approved')
            <p>Return approved. Please send the item to the following address:</p>
            <p>{{ $order->seller_message }}</p>
            <p>Your money will be returned to your account within 5 working days of recieving the items.</p>
        @elseif($order->return_status == 'Denied')
            <p>Return request denied. Seller's message: {{ $order->seller_message }}</p>
        @else
            <a href="{{ route('orders.returnForm', $order->id) }}" class="btn btn-warning">Request Return</a>
        @endif
    @elseif($order->status != 'Cancelled')
        <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-danger">Cancel Order</button>
        </form>
    @else
        <p>This order has been cancelled. If money was taken out of your account we will get this back to you within 5 working days.</p>
    @endif

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
        background-color: #4CAF50; 
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
