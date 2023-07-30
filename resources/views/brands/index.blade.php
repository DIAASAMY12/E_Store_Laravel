@extends('layouts.app')

@section('content')<h1>Brands</h1>
<table class="table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Notes</th>
        <th>Icon</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($brands as $brand)
        <tr>
            <td>{{ $brand->name }}</td>
            <td>{{ $brand->notes }}</td>
            <td>
                @if ($brand->icon)
                    <img src="/images/{{ $brand->icon }}" alt="{{ $brand->name }}" width="150" height="100">
                @else
                    No Icon
                @endif
            </td>
            <td>
                <a href="{{ route('brands.edit', $brand) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('brands.destroy', $brand) }}" method="post" style="display: inline-block;">
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
