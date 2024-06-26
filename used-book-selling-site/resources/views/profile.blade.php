@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
</div>

<div class="container profile-container">
    <h1 class="profile-title">Your profile page</h1>

    <ul class="profile-nav-list">
            <li class="profile-nav-item"><a href="{{ route('profile') }}">Personal Details</a></li>
            <li class="profile-nav-item"><a href="{{ route('profile.orderHistory') }}">Order History
            @if ($respondedReturnsCount > 0)
                <span class="notification-badge" style="background-color: green; color: white; border-radius: 50%; padding: 0.25em 0.5em; font-size: 0.75em; line-height: 1; vertical-align: super; margin-left: 5px;">
                    {{ $respondedReturnsCount }}
                </span>
            @endif
            </a></li>
            <li class="profile-nav-item">
                <a href="{{ route('profile.soldBooks') }}">
                    Sold Books
                    @if ($notificationsCount > 0)
                        <span class="notification-badge" style="background-color: red; color: white; border-radius: 50%; padding: 0.25em 0.5em; font-size: 0.75em; line-height: 1; vertical-align: super; margin-left: 5px;">{{ $notificationsCount }}</span>
                    @endif
                    @if ($requestedReturnsCount > 0)
                        <span class="notification-badge" style="background-color: red; color: white; border-radius: 50%; padding: 0.25em 0.5em; font-size: 0.75em; line-height: 1; vertical-align: super; margin-left: 5px;">
                            {{ $requestedReturnsCount }}
                        </span>
                    @endif
                </a>
            </li>
        </ul>

    <div class="profile-section personal-details">
        <h2>Personal Details</h2>
        <p>Name: {{ auth()->user()->name }}</p>
        <p>Email: {{ auth()->user()->email }}</p>
    </div>

    <div class="profile-section saved-addresses">
        <h2>Saved Addresses</h2>
        @foreach($addresses as $address)
            <div class="address">
                <p>
                    {{ $address->flat_number }} {{ $address->address }}, {{ $address->city }}, {{ $address->zip }}
                    @if($address->is_primary)
                        - Currently being used as your delivery address.
                    @endif
                </p>
                <div class="address-actions">
                    <form method="POST" action="{{ route('addresses.setPrimary', $address) }}" class="address-form">
                        @csrf
                        <button type="submit" class="btn btn-primary">Set as Primary</button>
                    </form>
                    <form method="POST" action="{{ route('addresses.delete', $address) }}" class="address-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>


@endsection
