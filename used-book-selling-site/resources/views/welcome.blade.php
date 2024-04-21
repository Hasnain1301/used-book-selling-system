@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
@endsection

@section('content')

<div class="welcome-header">
    <h1>Welcome to Books4Less</h1>
    <p>Find academic books at a fraction of the cost.</p> <br> <br>

    <img src="{{ asset('images/logo.jpg') }}" alt="Books4Less Logo" style="display: block; margin: 0 auto; width: 500px; height: auto;"> <br><br>

    <a href="{{ route('home') }}" class="btn-main">Shop Now</a>
</div>

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

@endsection
