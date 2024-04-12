@extends('layouts.base')

@section('content')

<div class="container">
    <h1>Return form</h1>
    
    <h2>Items in this order eligible for a return:</h2>
    <ul>
        @foreach($order->soldItems as $item)
            <li>
                <img src="{{ $item->listing_image }}" alt="" style="width:250px; height:auto;">
                {{ $item->listing_title }} - £{{ $item->listing_price }}
            </li>
        @endforeach
    </ul>

    @if($order->return_status == 'Requested')
        <button class="btn btn-secondary" disabled>Awaiting Approval from Seller</button>
    @else
        <form action="{{ route('orders.submitReturn', $order->id) }}" method="POST">
            @csrf
            <label for="return_reason">Reason for Return:</label>
            <textarea id="return_reason" name="return_reason" required></textarea>
            <button type="submit" class="btn btn-primary">Submit Return Request</button>
        </form>
    @endif

@endsection
