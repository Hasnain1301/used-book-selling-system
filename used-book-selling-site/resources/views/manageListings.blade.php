@extends('layouts.base')

@section('content')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/manage.css') }}">
@endsection

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

<h2>Add a new listing now by clicking below:</h2>
<form action="{{ route('listings.create', ['name' => auth()->user()->name]) }}" method="get" class="text-center">
    @csrf
    <button type="submit" class="btn-custom">Create a new listing now</button>
</form>

<h2>Your current listings</h2>

@if ($listings->isEmpty())
    <p>You have no listings yet.</p>
@else
    <div class="listings">
        @foreach ($listings as $listing)
            <div class="listing-item">
                <img src="{{ $listing->listingImage }}" alt="Listing Image">
                <h3>{{ $listing->listingTitle }}</h3>  
                <p>£{{ $listing->listingPrice }}</p>
                <p>By {{ $listing->listingAuthor }}</p>

                <a href="{{ route('listings.edit', $listing) }}" class="btn-custom">Edit listing</a> 
                
                <form action="{{ route('listings.delete', $listing) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-custom">Delete</button>
                </form>
            </div>
        @endforeach
    </div>
@endif

@endsection

