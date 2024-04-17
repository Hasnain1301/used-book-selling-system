@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/listings.css') }}">
@endsection

@section('content')

<div class="justify-content-center">
    @if(session()->has('success'))
        <div class="alert alert-success d-flex align-items-center justify-content-center">   
            {{ session('success') }}
        </div>          
    @endif
</div>  

<div class="justify-content-center">
    @if(session()->has('logout'))
        <div class="alert alert-success d-flex align-items-center justify-content-center">   
            {{ session('logout') }}
        </div>          
    @endif
</div>  

<div class="justify-content-center">
    @if(session()->has('registered'))
        <div class="alert alert-success d-flex align-items-center justify-content-center">   
            {{ session('registered') }}
        </div>          
    @endif
</div> 

<h2 class="text-center my-4">All books for sale</h2>

<div class="container mb-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('home') }}" method="GET" class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search for books..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                    @if(request('search'))
                        <a href="{{ route('home') }}" class="btn btn-outline-danger">Clear</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        @forelse($listings as $listing) 
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <a href="{{ route('listings.show', $listing->listingID) }}">
                        <img class="card-img-top" src="{{ asset($listing->listingImage) }}" alt="{{ $listing->listingTitle }}">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $listing->listingTitle }}</h5>
                        <p class="card-text">By {{ $listing->listingAuthor }}</p>
                        <div class="mt-auto">
                            <p class="card-text price">£{{ $listing->listingPrice }}</p>
                            <form action="{{ route('basket.add', ['listingId' => $listing->listingID]) }}" method="post" class="d-flex justify-content-between">
                                @csrf
                                <button type="submit" class="btn btn-primary">Add to Basket</button>
                                <button type="submit" name="buyNow" class="btn btn-warning">Buy now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <h5>No listings found.</h5>
            </div>
        @endforelse
    </div>
</div>

@endsection
