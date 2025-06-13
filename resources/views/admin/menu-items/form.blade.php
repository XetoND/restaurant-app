@csrf
<div class="card-body">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="name">Nama Menu</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Contoh: Nasi Goreng Spesial" value="{{ old('name', $menuItem->name ?? '') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="price">Harga</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                    </div>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" placeholder="Contoh: 25000" value="{{ old('price', $menuItem->price ?? '') }}" required>
                </div>
                @error('price')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="category">Kategori</label>
                <select class="form-control @error('category') is-invalid @enderror" id="category" name="category" required>
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    <option value="Makanan" {{ old('category', $menuItem->category ?? '') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="Minuman" {{ old('category', $menuItem->category ?? '') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                </select>
                @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="image">Gambar Menu</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image">
                    <label class="custom-file-label" for="image">Pilih file...</label>
                </div>
                @error('image')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="description">Deskripsi</label>
        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Deskripsi singkat mengenai menu...">{{ old('description', $menuItem->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="available" id="available" value="1" {{ old('available', $menuItem->available ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="available">
                    Tersedia untuk dijual
                </label>
            </div>
        </div>
        @if(isset($menuItem) && $menuItem->image)
            <div class="col-md-6 text-right">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                    <label class="form-check-label text-danger" for="remove_image">
                        Hapus Gambar Saat Ini
                    </label>
                </div>
                <img src="{{ asset('storage/' . $menuItem->image) }}" alt="Gambar saat ini" class="img-thumbnail mt-2" width="100">
            </div>
        @endif
    </div>
</div>

<div class="card-footer text-right">
    <a href="{{ route('admin.menu-items.index') }}" class="btn btn-secondary">Batal</a>
    <button type="submit" class="btn btn-primary">{{ isset($menuItem) ? 'Perbarui Menu' : 'Simpan Menu' }}</button>
</div>