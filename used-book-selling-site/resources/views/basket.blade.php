@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/basket.css') }}">
@endsection

@section('content')

<div class="container">
    <div class="basket">
        <div class="basket-items">
            @if (count($basketItems) > 0)
                @foreach ($basketItems as $basketItem)
                    <div class="item-card d-flex mb-4">
                        <img class="item-image" src="{{ $basketItem->listingImage }}" alt="Book image">
                        <div class="item-details">
                            <h5 class="item-title">{{ $basketItem->listingTitle }}</h5>
                            <p class="item-author">{{ $basketItem->listingAuthor }}</p>
                        </div>
                        <div class="item-price">£{{ $basketItem->listingPrice }}</div>
                        <form action="{{ route('basket.remove', ['listingId' => $basketItem->listing_id]) }}" method="post" class="remove-form ml-auto">
                            @csrf
                            @method('delete')
                            <button type="submit" class="remove-button">&times;</button>
                        </form>
                    </div>
                @endforeach
            @else
                <h1>Your basket is empty</h1>
            @endif
        </div>


        @if (count($basketItems) > 0)
            <div class="summary-box">
                <h2>Summary</h2>
                <div class="summary-content">
                    <p>Subtotal ({{ count($basketItems) }} Items)</p>
                    <p>£{{ $totalPrice }}</p>
                </div>
                <div class="checkout-btn">
                    <form action="{{ route('order.address') }}" method="get">
                        <button>Continue to checkout</button>
                    </form>
                </div>
            </div>
        @else
            <div class="summary-box">
                <div class="checkout-btn">
                    <form action="{{ route('home') }}" method="get">
                        <button>Continue shopping</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection