@extends('layouts.base')

@section('content')

<h1>Register page</h1>

<div class="d-flex align-items-center justify-content-center">
    <form action="{{ route('register') }}" method="post" class="card p-4 mt-3">

        @csrf

        <div class="form-floating mb-3">
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter your name" value="{{ old('name') }}">
            <label for="name">Name</label>

            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}">
            <label for="email">Email address</label>

            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter password">
            <label for="password">Password</label>

            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-enter your password">
            <label for="password_confirmation">Re-enter password</label>
        </div>

        <div class="d-flex align-items-center justify-content-center mb-3">
            <button type="submit" class="btn btn-primary">
                Register account now
            </button>
        </div>
    </form>
</div>

@endsection
