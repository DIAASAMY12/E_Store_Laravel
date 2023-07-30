<!-- resources/views/inventories/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <!-- resources/views/inventories/edit.blade.php -->
    <h1>Edit Inventory</h1>
    <form action="{{ route('inventories.update', $inventory) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $inventory->name }}" required>
        </div>
        <div class="form-group">
            <label>City</label>
            <select name="city_id" class="form-control" required>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ $inventory->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $inventory->phone }}" required>
        </div>
        <div class="form-group">
            <label>Is Active</label>
            <input type="checkbox" name="is_active" class="form-check-input" {{ $inventory->is_active ? 'checked' : '' }}>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>

@endsection
