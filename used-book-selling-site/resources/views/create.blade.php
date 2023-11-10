@extends('layouts.base')

@section('content')

<h1>Create a New Listing</h1>

<form action="{{ route('listings.add', ['name' => auth()->user()->name]) }}" enctype="multipart/form-data" method="post">
    @csrf
    <label for="listingTitle">Title:</label>
    <input type="text" name="listingTitle" required>
    <br>

    <label for="listingAuthor">Author:</label>
    <input type="text" name="listingAuthor" required>
    <br>

    <label for="listingDescription">Description:</label>
    <textarea name="listingDescription" required></textarea>
    <br>

    <label for="ISBN">ISBN:</label>
    <input type="text" name="ISBN" required>
    <br>

    <label for="listingCondition">Condition:</label>
    <select name="listingCondition" id="" required>
        <option value="">Select one</option>
        <option value="excellent">Excellent</option>
        <option value="good">Good</option>
        <option value="fair">Fair</option>
        <option value="poor">Poor</option>
    </select>
    <br>

    <label for="listingPrice">Price:</label>
    <input type="number" name="listingPrice" step="0.01" min="0" required>
    <br>

    <label for="listingImage">Image:</label>
    <input type="file" name="listingImage" required>
    <br>

    <button type="submit">Create Listing</button>
</form>

@endsection