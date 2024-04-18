@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')

<div class="container profile-container">
    <h1 class="profile-title">Your sold books</h1>

    <div class="profile-navigation">
        <ul class="profile-nav-list">
            <li class="profile-nav-item"><a href="{{ route('profile') }}">Personal Details</a></li>
            <li class="profile-nav-item"><a href="{{ route('profile.orderHistory') }}">Order History</a></li>
            <li class="profile-nav-item">
                <a href="{{ route('profile.soldBooks') }}">
                    Sold Books
                    @if ($notificationsCount > 0)
                        <span class="notification-badge" style="background-color: red; color: white; border-radius: 50%; padding: 0.25em 0.5em; font-size: 0.75em; line-height: 1; vertical-align: super; margin-left: 5px;">{{ $notificationsCount }}</span>
                    @endif
                </a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col"> 
            <div class="sold-books">
                <h2 class="section-title">Sold Books</h2>
                @if($soldBooks->isEmpty())
                    <p class="no-sold-books">You have not sold any books.</p>
                @else
                    <ul class="sold-books-list">
                        @foreach($soldBooks as $soldBook)
                            <li class="sold-book-item">
                                <span class="book-info">{{ $soldBook->listing_title }} - Sold for £{{ $soldBook->listing_price }} on {{ $soldBook->created_at->toFormattedDateString() }}</span>
                                @if($soldBook->order->status === 'Cancelled')
                                    <p class="order-cancelled">This order has been cancelled.</p>
                                    <form action="{{ route('sold.relist', $soldBook->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Relist book</button>
                                    </form>
                                @elseif($soldBook->order->return_status === 'Requested')
                                    <a href="{{ route('orders.viewReturn', $soldBook->orderID) }}" class="btn btn-info">View return request</a>
                                @endif

                                @if($soldBook->order->status === 'Dispatching')
                                    <form action="{{ route('completeOrder', $soldBook->id) }}" method="POST" style="margin-bottom: 0;">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Complete Order</button>
                                    </form>
                                @elseif($soldBook->order->status === 'Delivered')
                                    <span class="order-status-delivered">Delivered</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection