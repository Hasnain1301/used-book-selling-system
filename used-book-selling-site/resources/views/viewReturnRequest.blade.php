@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/returnReq.css') }}">
@endsection

@section('content')

<div class="container mt-5 mb-5">
    <h2 class="order-title">Return Request for Order #{{ $order->id }}</h2>
    <p class="order-detail">Reason for return: <span class="reason-text">{{ $order->return_reason }}</span></p>

    <h2 class="order-items-title">Items in this order:</h2>
    <ul class="order-items">
        @foreach($order->soldItems as $item)
            <li class="order-item">
                <img class="order-item-image" src="{{ $item->listing_image }}" alt="img">
                <span class="order-item-title">{{ $item->listing_title }}</span> - <span class="order-item-price">£{{ $item->listing_price }}</span>
            </li>
        @endforeach
    </ul>

    @if($order->return_status === 'Approved')
        <div class="alert alert-success" role="alert">
            You have accepted the return request. The buyer will be notified to return the item to your address.
        </div>
    @elseif($order->return_status === 'Denied')
        <div class="alert alert-danger" role="alert">
            You have rejected the return request. The buyer will be notified of the rejection.
        </div>
    @else
        <form action="{{ route('orders.acceptReturn', $order->id) }}" method="POST" class="mb-2">
            @csrf
            <button type="submit" class="btn btn-success">Accept</button>
        </form>
        <form action="{{ route('orders.rejectReturn', $order->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <textarea class="form-control" name="rejection_reason" required placeholder="Enter rejection reason"></textarea>
            </div>
            <button type="submit" class="btn btn-danger">Reject</button>
        </form>
    @endif
</div>
@endsection
