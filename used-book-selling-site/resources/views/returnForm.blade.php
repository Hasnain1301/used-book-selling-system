@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/returnForm.css') }}">
@endsection

@section('content')

<div class="container my-5">
    <h1 class="order-title">Return form</h1>
    
    <h2 class="order-items-title">Items in this order eligible for a return:</h2>
    <ul class="order-items">
        @foreach($order->soldItems as $item)
            <li class="order-item">
                <img class="order-item-image" src="{{ $item->listing_image }}" alt="">
                <span class="order-item-title">{{ $item->listing_title }}</span> - <span class="order-item-price">£{{ $item->listing_price }}</span>
            </li>
        @endforeach
    </ul>

    @if($order->return_status == 'Requested')
        <button class="btn btn-secondary" disabled>Awaiting Approval from Seller</button>
    @else
        <form action="{{ route('orders.submitReturn', $order->id) }}" method="POST" class="return-form">
            @csrf
            <div class="mb-3">
                <label for="return_reason" class="form-label">Reason for Return:</label>
                <textarea id="return_reason" name="return_reason" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Return Request</button>
        </form>
    @endif
</div>

@endsection
