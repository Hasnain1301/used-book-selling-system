@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

<div class="d-flex align-items-center justify-content-center vh-100">
    <div class="login-card">
        <h2>Welcome</h2>

        <div class="container">
            <div class="row justify-content-center">
                @if(session()->has('incorrect'))
                    <div class="alert alert-danger">   
                        {{ session('incorrect') }}
                    </div>          
                @endif
            </div>    
        </div>

        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder=" " value="{{ old('email') }}">
                <label for="email">Email address</label>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder=" ">
                <label for="password">Password</label>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-login">Login</button>
        </form>
        <div class="signup-link">
            Don't have an account? <a href="{{ route('register') }}">Sign Up Now</a>
        </div>
    </div>
</div>

@endsection
