@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="/css/login.css" type="text/css">
@endsection

@section('content')

<h1>Login page</h1>

<div class="container">
    <div class="justify-content-center">
        @if(session()->has('incorrect'))
            <div class="alert alert-danger d-flex align-items-center justify-content-center">   
                {{ session('incorrect') }}
            </div>          
        @endif
    </div>    
</div>

<div class="d-flex align-items-center justify-content-center">
    <form action="{{ route('login') }}" method="post" class="card p-4 mt-3">

        @csrf

        <div class="form-floating mb-3">
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}">
            <label for="email">Email address</label>

            @error('email')
                <div class="invalid-feedback">
                    @if($message == 'The email field is required.')
                        Please enter your email address.
                    @endif
                </div>
            @enderror
        </div>

        <div class="form-floating mb-3"> 
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
            <label for="password">Password</label>

            @error('password')
                <div class="invalid-feedback">
                    @if($message == 'The password field is required.')
                        Please enter your password.
                    @endif
                </div>
            @enderror
        </div>

        <div class="d-flex align-items-center justify-content-center mb-3">
            <button type="submit" class="btn btn-primary">
                Login
            </button>
        </div>
    </form>
</div>

@endsection
