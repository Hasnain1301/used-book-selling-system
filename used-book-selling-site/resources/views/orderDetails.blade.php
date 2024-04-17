@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/orderDetails.css') }}">
@endsection

@section('content')

    <div class="container mt-5 mb-5">
        <h1 class="mb-4">Order #B4S-{{ $order->id }} Details</h1>

        <div class="card p-4 shadow-sm">
            <p>Date of order: <strong>{{ $order->created_at->toFormattedDateString() }}</strong></p>
            <p>Status of your order: <strong>{{ $order->status }}</strong></p>

            <div class="progress" style="background-color: {{ $order->status == 'Cancelled' ? '#dc3545' : '#e0e0e0' }}; height: 20px; border-radius: 5px;">
                <div class="progress-bar" role="progressbar"
                    style="width: {{ $order->status == 'Cancelled' ? '100%' : ($order->status == 'Delivered' ? '100%' : ($order->status == 'Dispatching' ? '66%' : '33%')) }};
                            background-color: {{ $order->status == 'Cancelled' ? '#dc3545' : '#007bff' }};"
                    aria-valuenow="{{ $order->status == 'Cancelled' ? '0' : ($order->status == 'Delivered' ? '3' : ($order->status == 'Dispatching' ? '2' : '1')) }}"
                    aria-valuemin="0" aria-valuemax="3">
                </div>
            </div>

            <div class="status-steps d-flex justify-content-between mt-3 mb-4">
                <span class="{{ $order->status == 'Cancelled' ? 'text-muted' : ($order->status != 'Processing' ? 'text-primary' : '') }}">1. Order Paid For</span>
                <span class="{{ $order->status == 'Cancelled' ? 'text-muted' : ($order->status == 'Dispatching' || $order->status == 'Delivered' ? 'text-primary' : '') }}">2. Dispatching</span>
                <span class="{{ $order->status == 'Cancelled' ? 'text-muted' : ($order->status == 'Delivered' ? 'text-primary' : '') }}">3. Delivered</span>
            </div>

            <h2>Items in this order:</h2>
            <ul class="list-unstyled">
                @foreach($order->soldItems as $item)
                    <li class="mb-2">
                        <img src="{{ $item->listing_image }}" alt="" style="width:250px; height:auto;">
                        <strong>{{ $item->listing_title }}</strong> - £{{ $item->listing_price }}
                    </li>
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

        </div>

        <h3 class="mt-4"><a href="{{ route('profile.orderHistory') }}" class="text-dark">Back to all orders</a></h3>
    </div>

@endsection
