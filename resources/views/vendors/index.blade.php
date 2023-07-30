@extends('layouts.app')
@section('content')
<h1>Vendors</h1>
<table class="table">
    <thead>
    <tr>
        <th>Email</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Is Active</th>
        <th>Phone</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($vendors as $vendor)
        <tr>
            <td>{{ $vendor->email }}</td>
            <td>{{ $vendor->first_name }}</td>
            <td>{{ $vendor->last_name }}</td>
            <td>{{ $vendor->is_active ? 'Active' : 'Inactive' }}</td>
            <td>{{ $vendor->phone }}</td>
            <td>
                <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('vendors.destroy', $vendor) }}" method="post" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
