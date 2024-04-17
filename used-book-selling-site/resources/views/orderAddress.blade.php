@extends('layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')

<h2>Enter a new address here or scroll down to use a previously saved address:</h2>

<div class="form-container">
    <form action="{{ route('address.save') }}" method="post" class="address-form">
        @csrf
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required maxlength="255">
        </div>
        <div class="form-group">
            <label for="flat_number">Flat Number/House No:</label>
            <input type="text" id="flat_number" name="flat_number" maxlength="255">
        </div>
        <div class="form-group">
            <label for="city">Town/City:</label>
            <input type="text" id="city" name="city" required maxlength="255">
        </div>
        <div class="form-group">
            <label for="zip">Postcode/ZIP</label>
            <input type="text" id="zip" name="zip" required maxlength="20">
        </div>
        <div class="form-group">
            <label for="is_primary" class="checkbox-label">Save as primary address:</label>
            <input type="checkbox" id="is_primary" name="is_primary" value="1">  
        </div>
        <button type="submit" class="submit-button">Continue to payment</button>
    </form>
</div>

<div>
    <h2>Previously saved addresses:</h2>
    @if($addresses->count() > 0)
        @foreach($addresses as $address)
            <div class="address-card">
                <p><strong>Flat Number/House No:</strong> {{ $address->flat_number }}</p>
                <p><strong>Address:</strong> {{ $address->address }}</p>
                <p><strong>City:</strong> {{ $address->city }}</p>
                <p><strong>ZIP/Postal Code:</strong> {{ $address->zip }}</p>
                <p><strong>Currently in use:</strong> {{ $address->is_primary ? 'Yes' : 'No' }}</p>
                <form action="{{ route('address.setPrimary') }}" method="post" style="display: inline;">
                    @csrf
                    <input type="hidden" name="address_id" value="{{ $address->id }}">
                    <button type="submit" class="set-primary-button">Set as Primary</button>
                </form>
                <form action="{{ route('address.delete', $address) }}" method="post" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this address?');">Delete</button>
                </form>
            </div>
        @endforeach
    @else
        <h2>No previously saved addresses.</h2>
    @endif

    <div class="primary-address-button">
        @if($primaryAddress)
            <form action="{{ route('usePrimaryAddress') }}" method="post">
                @csrf
                <input type="hidden" name="primary_address_id" value="{{ $primaryAddress->id }}">
                <button type="submit" class="continue-button">Continue to payment with primary address</button>
            </form>
        @endif
    </div>
</div>

@endsection
