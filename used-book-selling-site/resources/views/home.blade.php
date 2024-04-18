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
    <div class="row">
        {{-- Sidebar for filters --}}
        <div class="col-md-3">
            <form action="{{ route('home') }}" method="GET">
                <h4>Filter by:</h4>

                <h5>Department</h5>
                @foreach($departments as $department)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="departments[]" value="{{ $department }}" id="department_{{ $department }}"
                        {{ is_array(request('departments')) && in_array($department, request('departments')) ? 'checked' : '' }}>
                    <label class="form-check-label" for="department_{{ $department }}">
                        {{ $department }}
                    </label>
                </div>
                @endforeach

                <h5>Year</h5>
                @foreach($years as $year)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="years[]" value="{{ $year }}" id="year_{{ $year }}"
                        {{ is_array(request('years')) && in_array($year, request('years')) ? 'checked' : '' }}>
                    <label class="form-check-label" for="year_{{ $year }}">
                        {{ ucfirst($year) }} Year
                    </label>
                </div>
                @endforeach

                <h5>Condition</h5>
                @foreach($conditions as $condition)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="conditions[]" value="{{ $condition }}" id="condition_{{ $condition }}"
                        {{ is_array(request('conditions')) && in_array($condition, request('conditions')) ? 'checked' : '' }}>
                    <label class="form-check-label" for="condition_{{ $condition }}">
                        {{ ucfirst($condition) }}
                    </label>
                </div>
                @endforeach

                <button type="submit" class="btn btn-primary mt-2">Apply Filters</button>
            </form>
            <a href="{{ route('home') }}" class="btn btn-secondary mt-2">Clear Filters</a>
        </div>

        <div class="col-md-9">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="search" placeholder="Search for books..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                    @if(request('search'))
                        <a href="{{ route('home') }}" class="btn btn-outline-danger">Clear</a>
                    @endif
                </div>
            </div>

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
                                    @auth
                                        <form action="{{ route('basket.add', ['listingId' => $listing->listingID]) }}" method="post" class="d-flex justify-content-between">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Add to Basket</button>
                                            <button type="submit" name="buyNow" class="btn btn-warning">Buy now</button>
                                        </form>
                                    @endauth

                                    @guest
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('login') }}" class="btn btn-primary">Login to purchase now</a>
                                        </div>
                                    @endguest
                                </div>
                            </div>
                        </div>
                </div>
                @empty
                <div class="col">
                    <h5>No listings available yet.</h5>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
