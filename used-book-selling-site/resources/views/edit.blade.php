@extends('layouts.base')

@section('content')

<h1>Edit listing</h1>

<form action="{{ route('listings.update', $listing) }}" method="post">
    @csrf
    @method('PUT')

    <label for="listingTitle">Title:</label>
    <input type="text" name="listingTitle" value="{{ $listing->listingTitle }}" required>
    <br>

    <label for="listingAuthor">Author:</label>
    <input type="text" name="listingAuthor" value="{{ $listing->listingAuthor }}" required>
    <br>

    <label for="listingDescription">Description:</label>
    <textarea name="listingDescription">{{ $listing->listingDescription}}</textarea>
    <br>

    <label for="ISBN">ISBN:</label>
    <input type="text" name="ISBN" value="{{ $listing->ISBN }}" required>
    <br>

    <label for="listingCondition">Condition:</label>
    <select name="listingCondition" id="" value="{{ $listing->listingCondition }}" required>
        <option value="">Select one</option>
        <option value="excellent">Excellent</option>
        <option value="good">Good</option>
        <option value="fair">Fair</option>
        <option value="poor">Poor</option>
    </select>
    <br>

    <label for="listingPrice">Price:</label>
    <input type="number" name="listingPrice" step="0.01" min="0" value="{{ $listing->listingPrice }}" required>
    <br>

    <label for="listingImage">Image URL:</label>
    <input type="file" name="listingImage">
    <p>Current image:</p>
    <img src="{{ asset($listing->listingImage) }}" alt="image" width="250" height="300">
    <br>

    <button type="submit">Update</button>
</form>


@endsection