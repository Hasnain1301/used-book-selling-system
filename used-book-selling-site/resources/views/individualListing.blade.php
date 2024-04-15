@extends('layouts.base')

@section('content')

<h1>Listings details</h1>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <img src="{{ asset($listing->listingImage) }}" alt="image" class="img-fluid">
            </div>
            <div class="col-md-4">
                <h1>{{ $listing->listingTitle }}</h1>
                <p>By: {{ $listing->listingAuthor }}</p>
                <p>{{ $listing->listingDescription }}</p>
                <p>Price: £{{ $listing->listingPrice }}</p>
                <p>ISBN: {{ $listing->ISBN }}</p>
                <p>Condition: {{ $listing->listingCondition }}</p>
                <p>Category: {{ $listing->listingCategory }}</p>
                <p>Department: {{ $listing->department }}</p>
                <p>Year: {{ $listing->year }}</p>

                <form action="{{ route('basket.add', ['listingId' => $listing->listingID]) }}" method="post">
                    @csrf
                    <button type="submit" name="buyNow" class="btn btn-success">Buy Now</button>
                </form>
            </div>
        </div>
    </div>

@endsection
