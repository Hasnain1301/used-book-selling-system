@extends('layouts.base')

@section('content')

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
    
</div>


@endsection
