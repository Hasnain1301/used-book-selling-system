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

<h1 class="text-center my-4">All books for sale</h1>

<div class="container">
    <div class="row">
        @foreach($listings as $listing) 
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <a href="{{ route('listings.show', $listing->listingID) }}">
                        <img class="card-img-top" src="{{ $listing->listingImage }}" alt="{{ $listing->listingTitle }}">
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
        @endforeach
    </div>
</div>

@endsection
