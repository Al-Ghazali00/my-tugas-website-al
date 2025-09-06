@extends('layouts.app')
@section('content')
<h3>Tambah Menu</h3>
<form method="post" action="{{ route('menus.store') }}" class="row g-3">@csrf
  <div class="col-md-6">
    <label class="form-label">Nama</label>
    <input name="name" class="form-control" value="{{ old('name') }}" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Kategori</label>
    <select name="category" class="form-select">
      <option value="makanan">Makanan</option>
      <option value="minuman">Minuman</option>
    </select>
  </div>
  <div class="col-md-3">
    <label class="form-label">Harga</label>
    <input name="price" type="number" step="0.01" class="form-control" value="{{ old('price') }}" required>
  </div>
  <div class="col-12">
    <label class="form-label">Deskripsi</label>
    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
  </div>
  <div class="col-12">
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('menus.index') }}" class="btn btn-secondary">Batal</a>
  </div>
</form>
@endsection
