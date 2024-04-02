@extends('layouts.base')

@section('content')

<div>
    <p><strong>Buyer:</strong> {{ $user->name }}</p>
    @if($tempAddress)
        <p><strong>Delivery Address:</strong> {{ $tempAddress->address }}, {{ $tempAddress->city }}, {{ $tempAddress->zip }}</p>
    @elseif($primaryAddress)
        <p><strong>Delivery Address:</strong> {{ $primaryAddress->address }}, {{ $primaryAddress->city }}, {{ $primaryAddress->zip }}</p>
    @else
        <p>No delivery address set.</p>
    @endif
</div>

@if($basketItems->isNotEmpty())
    <div>
        <h4>Item(s) you are purchasing:</h4>
        @foreach($basketItems as $item)
            <div>
                <p><strong>Title:</strong> {{ $item->listingTitle }}</p>
                <p><strong>Author:</strong> {{ $item->listingAuthor }}</p>
                <p><strong>Price:</strong> £{{ $item->listingPrice }}</p>
            </div>
        @endforeach
        <p><strong>Total price to pay:</strong> £{{ $totalPrice }}</p>
    </div>
@else
    <p>There is nothing to purchase.</p>
@endif

<h4>Payment options:</h4>

<div>
    <form action="{{ route('basket.checkout') }}" method="post">
        @csrf
        <button>Pay by card</button>
    </form>
</div>

@endsection
