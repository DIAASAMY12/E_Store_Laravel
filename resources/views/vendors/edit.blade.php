@extends('layouts.app')
@section('content')
<h1>Edit Vendor</h1>
<form action="{{ route('vendors.update', $vendor) }}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ $vendor->email }}" required>
    </div>
    <div class="form-group">
        <label>First Name</label>
        <input type="text" name="first_name" class="form-control" value="{{ $vendor->first_name }}" required>
    </div>
    <div class="form-group">
        <label>Last Name</label>
        <input type="text" name="last_name" class="form-control" value="{{ $vendor->last_name }}" required>
    </div>
    <div class="form-group">
        <label>Is Active</label>
        <input type="checkbox" name="is_active" class="form-check-input" {{ $vendor->is_active ? 'checked' : '' }}>
    </div>
    <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ $vendor->phone }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
