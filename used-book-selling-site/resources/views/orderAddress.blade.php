@extends('layouts.base')

@section('content')

<h1>Enter address please</h1>

<div>
    <form action="{{ route('address.save') }}" method="post">
        @csrf
        <div>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required maxlength="255">
        </div>
        <div>
            <label for="flat_number">Flat Number/House Name:</label>
            <input type="text" id="flat_number" name="flat_number" maxlength="255">
        </div>
        <div>
            <label for="city">Town/City:</label>
            <input type="text" id="city" name="city" required maxlength="255">
        </div>
        <div>
            <label for="zip">Postcode/ZIP</label>
            <input type="text" id="zip" name="zip" required maxlength="20">
        </div>
        <div>
            <label for="is_primary">Save as primary address:</label>
            <input type="checkbox" id="is_primary" name="is_primary" value="1">
        </div>
        <button type="submit">Continue to payment</button>
    </form>
</div>

<div>
    <h2>Previously saved addresses:</h2>
    @if($addresses->count() > 0)
        @foreach($addresses as $address)
            <div>
                <p><strong>Address:</strong> {{ $address->address }}</p>
                <p><strong>City:</strong> {{ $address->city }}</p>
                <p><strong>ZIP/Postal Code:</strong> {{ $address->zip }}</p>
                <p><strong>Currently in use:</strong> {{ $address->is_primary ? 'Yes' : 'No' }}</p>
                <form action="{{ route('address.setPrimary') }}" method="post">
                    @csrf
                    <input type="hidden" name="address_id" value="{{ $address->id }}">
                    <button type="submit">Set as Primary</button>
                </form>

                <br><br>
                <form action="{{ route('address.delete', $address) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this address?');">Delete</button>
                </form>
            </div>
        @endforeach
    @else
        <p>No previously saved addresses.</p>
    @endif
    
    <br><br>

    @if($primaryAddress)
        <form action="{{ route('usePrimaryAddress') }}" method="post">
            @csrf
            <input type="hidden" name="primary_address_id" value="{{ $primaryAddress->id }}">
            <button type="submit">Continue to payment</button>
        </form>
    @endif

</div>

@endsection
