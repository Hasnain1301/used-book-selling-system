@extends('layouts.base')

@section('content')

<div class="container">
    <div class="border p-4 mt-5">
        <h1 class="mb-4 text-center">Edit listing</h1>

        <div class="d-flex align-items-center justify-content-center">
            <form action="{{ route('listings.update', $listing) }}" method="post" class="card p-4 mt-3">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="listingTitle" class="form-label">Title:</label>
                    <input type="text" name="listingTitle" class="form-control" value="{{ $listing->listingTitle }}" required>
                </div>

                <div class="mb-3">
                    <label for="listingAuthor" class="form-label">Author:</label>
                    <input type="text" name="listingAuthor" class="form-control" value="{{ $listing->listingAuthor }}" required>
                </div>

                <div class="mb-3">
                    <label for="listingDescription" class="form-label">Description:</label>
                    <textarea name="listingDescription" class="form-control">{{ $listing->listingDescription}}</textarea> 
                </div>

                <div class="mb-3">
                    <label for="ISBN" class="form-label">ISBN:</label>
                    <input type="text" name="ISBN" class="form-control" value="{{ $listing->ISBN }}" required>
                </div>

                <div class="mb-3">
                    <label for="listingCondition" class="form-label">Condition:</label>
                    <select name="listingCondition" id="listingCondition" class="form-control" required>
                        <option value="">Select one</option>
                        <option value="excellent" {{ $listing->listingCondition === 'excellent' ? 'selected' : '' }}>Excellent</option>
                        <option value="good" {{ $listing->listingCondition === 'good' ? 'selected' : '' }}>Good</option>
                        <option value="fair" {{ $listing->listingCondition === 'fair' ? 'selected' : '' }}>Fair</option>
                        <option value="poor" {{ $listing->listingCondition === 'poor' ? 'selected' : '' }}>Poor</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="listingPrice" class="form-label">Price:</label>
                    <input type="number" name="listingPrice" class="form-control" step="0.01" min="0" value="{{ $listing->listingPrice }}" required> 
                </div>

                <div class="mb-3">
                <label for="listingImage" class="form-label">Image URL:</label>
                    <input type="file" name="listingImage" class="form-control">
                    <p>Current image:</p>
                    <img src="{{ asset($listing->listingImage) }}" alt="image" width="250" height="300"> 
                </div>

                <div class="d-flex align-items-center justify-content-center mb-3">
                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection