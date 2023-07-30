@extends('layouts.app')

@section('content')
    <h1>Items</h1>


    <form action="{{ route('items.index') }}" method="GET">
        <div class="form-group">
            <label for="brand">Brand:</label>
            <select name="brand" id="brand">
                <option value="">All Brands</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="brand">Vendor:</label>
            <select name="vendor" id="vendor">
                <option value="">All Vendors</option>
                @foreach ($vendors as $vendor)
                    <option value="{{ $vendor->id }}">{{ $vendor->first_name  }} {{$vendor->last_name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="inventory">Inventory:</label>
            <select name="inventory" id="inventory">
                <option value="">All Inventories</option>
                @foreach ($inventories as $inventory)
                    <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
                @endforeach
            </select>
        </div>

        {{--    <div class="form-group">--}}
        {{--        <label for="total_quantity">Total Quantity Exceeding 50:</label>--}}
        {{--        <input type="checkbox" name="total_quantity" value="1" id="total_quantity">--}}
        {{--    </div>--}}

        <button type="submit">Apply Filters</button>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Brand</th>
            {{--        <th>Quantity</th>--}}
            <th>Image</th>
            <th>Is Active</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->brand->name }}</td>
                {{--            <td>{{ $item->inventoriesItem->quantity }}</td>--}}
                <td>
                    @if ($item->image)
                        <img src="{{asset('storage/' . $item->image) }}" alt="{{ $item->name }}" width="150"
                             height="100">
                    @else
                        No Image
                    @endif
                </td>
                <td>{{ $item->is_active ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('items.edit', $item) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('items.destroy', $item) }}" method="post" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <form action="{{ route('cart.add', $item->id) }}" method="POST">
                        @csrf
                        <input id="quantity" type="number" name="quantity">
                        <button type="submit">Add to Cart</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
