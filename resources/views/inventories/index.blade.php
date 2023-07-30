<!-- resources/views/inventories/index.blade.php -->

@extends('layouts.app')

@section('content')
    <!-- resources/views/inventories/index.blade.php -->
    <h1>Inventories</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>City</th>
            <th>Phone</th>
            <th>Is Active</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($inventories as $inventory)
            <tr>
                <td>{{ $inventory->name }}</td>
                <td>{{ $inventory->city->name }}</td>
                <td>{{ $inventory->phone }}</td>
                <td>{{ $inventory->is_active ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('inventories.edit', $inventory) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('inventories.destroy', $inventory) }}" method="post" style="display: inline-block;">
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
