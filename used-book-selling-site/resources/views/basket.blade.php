@extends('layouts.base')

@section('content')

<div class="container">
        <h1>Your Basket</h1>

        @if (count($basketItems) > 0)
        <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Author</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($basketItems as $basketItem)
                        <tr>
                            <td>{{ $basketItem->listingTitle }}</td>
                            <td><img src="{{ $basketItem->listingImage }}" alt=""></td>
                            <td>{{ $basketItem->listingAuthor }}</td>
                            <td>£{{ $basketItem->listingPrice }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div>
                <h4>Total: £{{ $totalPrice }}</h4>
            </div>
            
        @else
            <p>Your basket is empty</p>
        @endif
    </div>

@endsection