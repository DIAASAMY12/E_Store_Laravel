<!-- resources/views/inventories/create.blade.php -->

@extends('layouts.app')

@section('content')
    <!-- resources/views/inventories/create.blade.php -->
    <h1>Create Inventory</h1>
    <form action="{{ route('inventories.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>City</label>
            <select name="city_id" class="form-control" required>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="is_active">Active</label>
            <input type="checkbox" name="is_active" id="is_active" value="1" @if(old('is_active', 1)) checked @endif>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>

@endsection
