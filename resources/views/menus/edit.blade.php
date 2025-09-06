@extends('layouts.app')
@section('content')
<h3>Edit Menu</h3>
<form method="post" action="{{ route('menus.update',$menu) }}" class="row g-3">@csrf @method('PUT')
  <div class="col-md-6">
    <label class="form-label">Nama</label>
    <input name="name" class="form-control" value="{{ old('name',$menu->name) }}" required>
  </div>
  <div class="col-md-3">
    <label class="form-label">Kategori</label>
    <select name="category" class="form-select">
      @foreach(['makanan','minuman'] as $c)
        <option value="{{ $c }}" @selected(old('category',$menu->category)==$c) class="text-capitalize">{{ $c }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3">
    <label class="form-label">Harga</label>
    <input name="price" type="number" step="0.01" class="form-control" value="{{ old('price',$menu->price) }}" required>
  </div>
  <div class="col-12">
    <label class="form-label">Deskripsi</label>
    <textarea name="description" class="form-control">{{ old('description',$menu->description) }}</textarea>
  </div>
  <div class="col-12">
    <button class="btn btn-primary">Update</button>
    <a href="{{ route('menus.index') }}" class="btn btn-secondary">Kembali</a>
  </div>
</form>
@endsection
