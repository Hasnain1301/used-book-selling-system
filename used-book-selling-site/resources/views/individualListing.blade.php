@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/listing.css') }}">
@endsection

@section('content')

<div class="listing-container mt-4">
    <div class="listing-image">
        <img src="{{ asset($listing->listingImage) }}" alt="image" class="img-fluid">
    </div>
    <div class="listing-details">
        <h1>{{ $listing->listingTitle }}</h1>
        <p>By: {{ $listing->listingAuthor }}</p>
        <p id="short-description">{{ Str::limit($listing->listingDescription, 150, '...') }}</p>
        <div id="full-description" style="display:none;">
            <p>{{ $listing->listingDescription }}</p>
        </div>
        <button onclick="toggleDescription()" id="toggle-description-btn">Read full description</button> <br>
        <p>Price: £{{ $listing->listingPrice }}</p>
        <p>ISBN: {{ $listing->ISBN }}</p>
        <p>Condition: {{ $listing->listingCondition }}</p>
        <p>Department: {{ $listing->department }}</p>
        <p>Year: {{ $listing->year }}</p>

        @auth

            @if(auth()->id() != $listing->userID)
                <form action="{{ route('basket.add', ['listingId' => $listing->listingID]) }}" method="post">
                    @csrf
                    <button type="submit" name="buyNow" class="btn-custom">Buy Now</button>
                </form>
            @else
                <button class="btn btn-secondary disabled">This is your listing</button>
            @endif

        @endauth

        @guest
            <a href="{{ route('login') }}" class="btn-custom" style="text-decoration: none;">Login to buy now</a>
        @endguest
    </div>
</div>

<script>
    function toggleDescription() {
        var shortDescription = document.getElementById('short-description');
        var fullDescription = document.getElementById('full-description');
        var toggleBtn = document.getElementById('toggle-description-btn');

        if (fullDescription.style.display === 'none') {
            shortDescription.style.display = 'none';
            fullDescription.style.display = 'block';
            toggleBtn.textContent = 'Show Less';
        } else {
            fullDescription.style.display = 'none';
            shortDescription.style.display = 'block';
            toggleBtn.textContent = 'Read full description';
        }
    }
</script>

@endsection
