@extends('layouts.base')

@section('content')

<h1>Welcome page</h1>

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