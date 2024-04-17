@extends('layouts.base')

@section('js')
<script src="{{ asset('js/findISBN.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')

<div class="container custom-container">
    <div class="border p-4 mt-5 custom-border">
        <h1 class="mb-4 text-center custom-header">Create a New Listing</h1>

        <div class="d-flex align-items-center justify-content-center">
            <form action="{{ route('listings.add', ['name' => auth()->user()->name]) }}" enctype="multipart/form-data" method="post" id="listingForm" class="card p-4 mt-3">
                @csrf

                <div class="mb-3 custom-form-group">
                    <label for="ISBN" class="form-label custom-label">ISBN:</label>
                    <input type="text" name="ISBN" id="ISBN" placeholder="Enter ISBN" class="form-control custom-input @error('ISBN') is-invalid @enderror" value="{{ old('ISBN') }}"> <br>
                    <button type="button" onclick="getBookInfo()" class="btn custom-button">Get Book Info</button>

                    @error('ISBN')
                        <div class="custom-invalid-feedback">
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
                <label for="department" class="form-label">Department:</label>
                    <select name="department" class="form-select @error('department') is-invalid @enderror" id="department">
                        <option value="">Select department</option>
                        <option value="Aston Business School" {{ old('department') == 'Aston Business School' ? 'selected' : '' }}>Aston Business School</option>
                        <option value="Aston Law School" {{ old('department') == 'Aston Law School' ? 'selected' : '' }}>Aston Law School</option>
                        <option value="Aston Medical School" {{ old('department') == 'Aston Medical School' ? 'selected' : '' }}>Aston Medical School</option>
                        <option value="Health and Life Sciences" {{ old('department') == 'Health and Life Sciences' ? 'selected' : '' }}>Health and Life Sciences</option>
                        <option value="College of Engineering and Physical Sciences" {{ old('department') == 'College of Engineering and Physical Sciences' ? 'selected' : '' }}>College of Engineering and Physical Sciences</option>
                        <option value="College of Business and Social Sciences" {{ old('department') == 'College of Business and Social Sciences' ? 'selected' : '' }}>College of Business and Social Sciences</option>
                        <option value="School of Social Sciences and Humanities" {{ old('department') == 'School of Social Sciences and Humanities' ? 'selected' : '' }}>School of Social Sciences and Humanities</option>
                    </select>         

                    @error('department')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="year" class="form-label">Year:</label>
                    <select name="year" class="form-select @error('year') is-invalid @enderror" id="year">
                        <option value="">Select year of study</option>
                        <option value="first" {{ old('year') == 'first' ? 'selected' : '' }}>First</option>
                        <option value="second" {{ old('year') == 'second' ? 'selected' : '' }}>Second</option>
                        <option value="third" {{ old('year') == 'third' ? 'selected' : '' }}>Third</option>
                        <option value="fourth" {{ old('year') == 'fourth' ? 'selected' : '' }}>Fourth</option>
                        <option value="final" {{ old('year') == 'final' ? 'selected' : '' }}>Final</option>
                    </select>

                    @error('year')
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
                    <button type="submit" class="btn custom-submit-button">
                        Create Listing
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
    
@endsection
