@extends('layouts.base')

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

<div class="container">
    <h1>Your profile page</h1>

    <div class="profile-navigation">
        <ul style="list-style: none; padding: 0; display: flex; justify-content: space-evenly;">
            <li><a href="{{ route('profile') }}">Personal Details</a></li>
            <li><a href="{{ route('profile.orderHistory') }}">Order History</a></li>
            <li><a href="{{ route('profile.soldBooks') }}">Sold Books</a></li>
        </ul>
    </div>


    <div class="row mb-4">
        <div class="col">
            <h2>Personal Details</h2>
            <p>Name: {{ auth()->user()->name }}</p>
            <p>Email: {{ auth()->user()->email }}</p>
        </div>
    </div>

    <h2>Saved Addresses</h2>
    @foreach($addresses as $address)
    <div class="address" style="display: flex; align-items: center; justify-content: space-between;">
    <p style="margin: 0; flex-grow: 1;">
        {{ $address->flat_number }} {{ $address->address }}, {{ $address->city }}, {{ $address->zip }}
        @if($address->is_primary)
        - Currently being used as your delivery address.
        @endif
    </p>
    <div>
        <form method="POST" action="{{ route('addresses.setPrimary', $address) }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-primary">Set as Primary</button>
        </form>
        <form method="POST" action="{{ route('addresses.delete', $address) }}" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
    <br>
</div>
@endforeach
    
</div>


@endsection
