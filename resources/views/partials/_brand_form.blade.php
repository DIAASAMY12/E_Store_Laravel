@extends('layouts.app')

@section('content')<form action="{{ $action }}" method="post" enctype="multipart/form-data">
    @csrf
    @if (isset($method))
        @method($method)
    @endif
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $brand->name ?? '') }}" required>
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label>Notes</label>
        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $brand->notes ?? '') }}</textarea>
        @error('notes')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label>Icon (PNG, JPG, JPEG only)</label>
        <input type="file" name="icon" class="form-control-file @error('icon') is-invalid @enderror">
        @error('icon')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection
