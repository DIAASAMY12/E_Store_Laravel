@extends('layouts.app')

@section('content')
    <h1>Inventory Items</h1>

    <a href="{{ route('inventory_items.create') }}" class="btn btn-success">Add New Inventory Item</a>

    <table class="table">
        <thead>
        <tr>
            <th>Item</th>
            <th>Inventory</th>
            <th>Quantity</th>
{{--            <th>Action</th>--}}
        </tr>
        </thead>
        <tbody>
        @foreach ($inventoryItems as $inventoryItem)
            <tr>
                <td>{{ $inventoryItem->item->name }}</td>
                <td>{{ $inventoryItem->inventory->name }}</td>
                <td>{{ $inventoryItem->quantity }}</td>
{{--                <td>--}}
{{--                    <a href="{{ route('inventory_items.edit', $inventoryItem) }}" class="btn btn-primary">Edit</a>--}}
{{--                    <form action="{{ route('inventory_items.destroy', $inventoryItem) }}" method="POST" style="display: inline;">--}}
{{--                        @csrf--}}
{{--                        @method('DELETE')--}}
{{--                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>--}}
{{--                    </form>--}}
{{--                </td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
