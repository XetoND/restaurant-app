<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $menuItem->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control">{{ old('description', $menuItem->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label>Price</label>
    <input type="number" name="price" step="0.01" class="form-control" value="{{ old('price', $menuItem->price ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Available</label>
    <select name="available" class="form-select">
        <option value="1" {{ old('available', $menuItem->available ?? true) ? 'selected' : '' }}>Yes</option>
        <option value="0" {{ old('available', $menuItem->available ?? true) ? '' : 'selected' }}>No</option>
    </select>
</div>

<div class="mb-3">
    <label>Image</label>
    <input type="file" name="image" class="form-control">
    @if (!empty($menuItem->image))
        <img src="{{ asset('storage/' . $menuItem->image) }}" class="img-thumbnail mt-2" width="150">
    @endif
</div>
