<!-- resources/views/purchase_orders/create.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Create Purchase Order</h1>

    <form action="{{ route('purchase_orders.store') }}" method="post">
        @csrf
        <div>
            <label for="item_id">Select Item:</label>
            <select name="item_id" id="item_id">
                @foreach ($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="In_Progress">In_Progress</option>
                <option value="Delivered">Delivered</option>
            </select>
        </div>
        <div>
            <label for="stop_purchasing">Stop Purchasing:</label>
            <input type="checkbox" name="stop_purchasing" id="stop_purchasing" value="1">
        </div>
        <div>
            <label for="inventory_id">Choose Inventory:</label>
            <select name="inventory_id" id="inventory_id">
                @foreach ($inventories as $inventory)
                    <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
                @endforeach
            </select>
        </div>

        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
