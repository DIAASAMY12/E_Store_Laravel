@extends('layouts.app')

@section('content')
    <h1>Add New Inventory Item</h1>

    <form action="{{ route('inventory_items.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="item_id">Item:</label>
            <select name="item_id" id="item_id">
                @foreach ($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="inventory_id">Inventory:</label>
            <select name="inventory_id" id="inventory_id">
                @foreach ($inventories as $inventory)
                    <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}">
        </div>
        <button type="submit" class="btn btn-success">Create Inventory Item</button>
    </form>
@endsection
