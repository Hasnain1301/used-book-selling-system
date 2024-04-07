@extends('layouts.base')

@section('content')

<h1>Create/Manage listings</h1>

<div class="justify-content-center">
    @if(session()->has('added'))
        <div class="alert alert-success d-flex align-items-center justify-content-center">   
            {{ session('added') }}
        </div>          
    @endif
</div>  

<div class="justify-content-center">
    @if(session()->has('delete'))
        <div class="alert alert-success d-flex align-items-center justify-content-center">   
            {{ session('delete') }}
        </div>          
    @endif
</div>  

<h2>Create a New Listing</h2>
<form action="{{ route('listings.create', ['name' => auth()->user()->name]) }}" method="get">
    @csrf
    <button type="submit">Create Listing</button>
</form>

<h2>Your Listings</h2>

@if ($listings->isEmpty())
    <p>You have no listings yet.</p>
@else
    @foreach ($listings as $listing)
        <img src="{{ $listing->listingImage }}" alt="image" width="250" height="300"> <br>
        {{ $listing->listingTitle }} <br>  
        £{{ $listing->listingPrice }} <br>
        By {{ $listing->listingAuthor }} <br>

        <button><a href="{{ route('listings.edit', $listing) }}">Edit listing</a></button> <br><br> 
        
        <form action="{{ route('listings.delete', $listing) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>

    @endforeach
@endif

@endsection

