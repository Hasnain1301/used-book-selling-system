@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')

<div class="d-flex align-items-center justify-content-center vh-100">
    <div class="login-card">
        <h2>Register</h2>
        <form action="{{ route('register') }}" method="post">
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

            <button type="submit" class="btn-login">Register account now</button>
        </form>

        <div class="signup-link">
            Already have an account? <a href="{{ route('login') }}">Login</a>
        </div>

    </div>
</div>

@endsection
