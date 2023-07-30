@extends('layouts.app')
@section('content')
<h1>Create Vendor</h1>
<form action="{{ route('vendors.store') }}" method="post">
    @csrf
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label>First Name</label>
        <input type="text" name="first_name" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Last Name</label>
        <input type="text" name="last_name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="is_active">Active</label>
        <input type="checkbox" name="is_active" id="is_active" value="1" @if(old('is_active', 1)) checked @endif>
    </div>
    <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>
@endsection
