<!-- resources/views/partials/_item_form.blade.php -->
<form action="{{ $action }}" method="post" enctype="multipart/form-data">
    @csrf
    @if (isset($method))
        @method($method)
    @endif
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $item->name ?? '') }}" required>
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label>Brand</label>
        <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror" required>
            <option value="">Select Brand</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" {{ old('brand_id', $item->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                    {{ $brand->name }}
                </option>
            @endforeach
        </select>
        @error('brand_id')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label>Image (PNG, JPG, JPEG only)</label>
        <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror">
        @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="is_active">Active</label>
        <input type="checkbox" name="is_active" id="is_active" value="1" @if(old('is_active', 1)) checked @endif>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
