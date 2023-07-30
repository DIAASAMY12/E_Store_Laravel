@extends('layouts.app')

@section('content')
    <h1>Edit City</h1>

    <form action="{{ route('cities.update', $city) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $city->name) }}" required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="country_id">Country</label>
            <select name="country_id" id="country_id" class="form-control @error('country_id') is-invalid @enderror" required>
                <option value="">Select a country</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" {{ old('country_id', $city->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                @endforeach
            </select>
            @error('country_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
