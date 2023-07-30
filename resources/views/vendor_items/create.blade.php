@extends('layouts.app')

@section('content')
    <h1>Add New Vendor Item</h1>

    <form action="{{ route('vendor_items.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="vendor_id">Vendor:</label>
            <select name="vendor_id" id="vendor_id">
                @foreach ($vendors as $vendor)
                    <option value="{{ $vendor->id }}">{{ $vendor->first_name }} {{ $vendor->last_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="item_id">Item:</label>
            <select name="item_id" id="item_id">
                @foreach ($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}">
        </div>
        <button type="submit" class="btn btn-success">Create Vendor Item</button>
    </form>
@endsection
