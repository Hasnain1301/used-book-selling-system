@extends('layouts.base')

@section('content')

<h1>Your profile page</h1>

<p>Name: {{ auth()->user()->name }}</p>
<p>Email: {{ auth()->user()->email }}</p>

@endsection
