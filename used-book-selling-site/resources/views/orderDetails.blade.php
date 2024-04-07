@extends('layouts.base')

@section('content')

    <h1>Order #{{ $order->id }} Details</h1>

    <p>Status of order {{ $order->status }}</p>
    <p>Date of order: {{ $order->created_at->toFormattedDateString() }}</p>

    <h2>Items in this order:</h2>
    <ul>
        @foreach($order->soldItems as $item)
            <li>{{ $item->listing_title }} - £{{ $item->listing_price }}</li>
        @endforeach
    </ul>

@endsection


