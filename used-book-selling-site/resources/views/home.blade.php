@extends('layouts.base')

@section('content')

<h1>Welcome page</h1>

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

<h1>All books for sale</h1>

@foreach($listings as $listing) 
    <a href="{{ route('listings.show', $listing->listingID) }}">
        <img src="{{ $listing->listingImage }}" alt="image" width="250" height="300"> <br>
        {{ $listing->listingTitle }} <br>  
        £{{ $listing->listingPrice }} <br>
        By {{ $listing->listingAuthor }} <br>

        <form action="{{ route('basket.add', ['listingId' => $listing->listingID]) }}" method="post">
            @csrf
            <button type="submit">Add to Basket</button>
            
            <br><br>

            <button type="submit" name="buyNow">Buy now</button>
        </form>
    </a>

    <br><br>
@endforeach

@endsection
