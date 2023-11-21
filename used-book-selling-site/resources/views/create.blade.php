@extends('layouts.base')

@section('js')
<script src="{{ asset('js/findISBN.js') }}"></script>
@endsection

@section('content')

<h1>Create a New Listing</h1>

<div class="d-flex align-items-center justify-content-center">
    <form action="{{ route('listings.add', ['name' => auth()->user()->name]) }}" enctype="multipart/form-data" method="post" id="listingForm" class="card p-4 mt-3">
        @csrf

        <div class="mb-3">
            <label for="ISBN" class="form-label">ISBN:</label>
            <input type="text" name="ISBN" id="ISBN" placeholder="Enter ISBN" class="form-control @error('ISBN') is-invalid @enderror" value="{{ old('ISBN') }}">
            <button type="button" onclick="getBookInfo()">Get Book Info</button>

            @error('ISBN')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>
       

        <div class="mb-3">
            <label for="listingTitle" class="form-label">Title:</label>
            <input type="text" name="listingTitle" id="listingTitle" class="form-control @error('listingTitle') is-invalid @enderror" placeholder="Enter listing title" value="{{ old('listingTitle') }}">

            @error('listingTitle')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <div class="mb-3">
            <label for="listingAuthor" class="form-label">Author:</label>
            <input type="text" name="listingAuthor" id="listingAuthor" class="form-control @error('listingAuthor') is-invalid @enderror" placeholder="Enter listing author">

            @error('listingAuthor')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <div class="mb-3">
            <label for="listingDescription" class="form-label">Description:</label>
            <textarea name="listingDescription" class="form-control @error('listingDescription') is-invalid @enderror" placeholder="Enter listing description">{{ old('listingDescription') }}</textarea>

            @error('listingDescription')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            
        </div>
        
        <div class="mb-3">
            <label for="listingCondition" class="form-label">Condition:</label>
            <select name="listingCondition" id="listingCondition" class="form-select @error('listingCondition') is-invalid @enderror">
                <option value="">Select one</option>
                <option value="excellent" {{ old('listingCondition') == 'excellent' ? 'selected' : '' }}>Excellent</option>
                <option value="good" {{ old('listingCondition') == 'good' ? 'selected' : '' }}>Good</option>
                <option value="fair" {{ old('listingCondition') == 'fair' ? 'selected' : '' }}>Fair</option>
                <option value="poor" {{ old('listingCondition') == 'poor' ? 'selected' : '' }}>Poor</option>
            </select>

            @error('listingCondition')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <div class="mb-3">
            <label for="listingPrice" class="form-label">Price:</label>
            <input type="number" name="listingPrice" step="0.01" min="0" class="form-control @error('listingPrice') is-invalid @enderror" placeholder="Enter listing price" value="{{ old('listingPrice') }}">

            @error('listingPrice')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <div class="mb-3">
            <label for="listingImage" class="form-label">Image:</label>
            <input type="file" name="listingImage" class="form-control @error('listingImage') is-invalid @enderror">

            @error('listingImage')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>

        <div class="d-flex align-items-center justify-content-center mb-3">
            <button type="submit" class="btn btn-primary">
                Create Listing
            </button>
        </div>

    </form>
</div>
    
@endsection
