@extends('layouts.app')

@section('content')
    <h1>Edit Inventory Item</h1>

    <form action="{{ route('inventory_items.update', $inventoryItem) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="item_id">Item:</label>
            <select name="item_id" id="item_id">
                @foreach ($items as $item)
                    <option value="{{ $item->id }}" {{ $inventoryItem->item_id == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="inventory_id">Inventory:</label>
            <select name="inventory_id" id="inventory_id">
                @foreach ($inventories as $inventory)
                    <option value="{{ $inventory->id }}" {{ $inventoryItem->inventory_id == $inventory->id ? 'selected' : '' }}>
                        {{ $inventory->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" value="{{ $inventoryItem->quantity }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Inventory Item</button>
    </form>
@endsection
