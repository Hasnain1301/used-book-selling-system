@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')

<div class="container profile-container">
    <h1 class="profile-title">Order history</h1>

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

    <div class="row mb-4">
        <div class="col">
            <div class="order-history">
                <h2 class="section-title">Order History</h2>
                @if($orders->isEmpty())
                    <p class="no-orders">You have no orders.</p>
                @else
                    <ul class="order-list">
                        @foreach($orders as $order)
                            <li class="order-item">
                                <span class="order-info">Order #{{ $order->id }} - {{ $order->created_at->toFormattedDateString() }}</span>
                                <span class="order-status">Status: {{ $order->status }}</span>
                                @if($order->return_status == 'Requested')
                                    <a href="{{ route('profile.orderDetails', $order->id) }}" class="order-link">Track return details</a>
                                @else
                                    <a href="{{ route('profile.orderDetails', $order->id) }}" class="order-link">Track orders/View Details</a>
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
