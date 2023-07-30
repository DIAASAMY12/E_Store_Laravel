@extends('layouts.app')

@section('content')
    <h1>Vendor Items</h1>

    <a href="{{ route('vendor_items.create') }}" class="btn btn-success">Add New Vendor Item</a>

    <table class="table">
        <thead>
        <tr>
            <th>Vendor</th>
            <th>Item</th>
            <th>Quantity</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($vendorItems as $vendorItem)
            <tr>
                <td>{{ $vendorItem->vendor->first_name }} {{ $vendorItem->vendor->last_name }}</td>
                <td>{{ $vendorItem->item->name }}</td>
                <td>{{ $vendorItem->quantity }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
