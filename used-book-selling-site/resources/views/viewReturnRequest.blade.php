@extends('layouts.base')

@section('content')

<div class="container">
    <h2>Return Request for Order #{{ $order->id }}</h2>
    <p>Reason for return: {{ $order->return_reason }}</p>

    <h2>Items in this order:</h2>
    <ul>
        @foreach($order->soldItems as $item)
            <li>
                <img src="{{ $item->listing_image }}" alt="img" style="width:250px; height:auto;">
                {{ $item->listing_title }} - £{{ $item->listing_price }}
            </li>
        @endforeach
    </ul>

    @if($order->return_status === 'Approved')
        <div class="alert alert-success" role="alert">
            You have accepted the return request. The buyer will be notified to return the item to your address.
        </div>
    @elseif($order->return_status === 'Denied')
        <div class="alert alert-success" role="alert">
            You have rejected the return request. The buyer will be notified of the rejection.
        </div>
    @else
        <form action="{{ route('orders.acceptReturn', $order->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Accept</button>
        </form>
        <form action="{{ route('orders.rejectReturn', $order->id) }}" method="POST">
            @csrf
            <textarea name="rejection_reason" required placeholder="Enter rejection reason"></textarea>
            <button type="submit" class="btn btn-danger">Reject</button>
        </form>
    @endif

</div>


@endsection