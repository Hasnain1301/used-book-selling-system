@extends('layouts.base')

@section('content')

<div class="container">
    <h1>Your sold books</h1>

    <div class="profile-navigation">
        <ul style="list-style: none; padding: 0; display: flex; justify-content: space-evenly;">
            <li><a href="{{ route('profile') }}">Personal Details</a></li>
            <li><a href="{{ route('profile.orderHistory') }}">Order History</a></li>
            <li><a href="{{ route('profile.soldBooks') }}">Sold Books</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col">
            <h2>Sold Books</h2>
            @if($soldBooks->isEmpty())
                <p>You have not sold any books.</p>
            @else
                <ul>
                    @foreach($soldBooks as $soldBook)
                        <li>{{ $soldBook->listing_title }} - Sold for £{{ $soldBook->listing_price }} on {{ $soldBook->created_at->toFormattedDateString() }}</li>
                    @endforeach
                </ul>
            @endif
    </div>
</div>


@endsection

