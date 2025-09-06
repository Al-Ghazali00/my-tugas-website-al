@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Menu</h3>
  <a href="{{ route('menus.create') }}" class="btn btn-primary">Tambah Menu</a>
</div>
<table class="table table-striped">
  <thead><tr><th>Nama</th><th>Kategori</th><th>Harga</th><th></th></tr></thead>
  <tbody>
  @foreach($menus as $m)
    <tr>
      <td>{{ $m->name }}</td>
      <td class="text-capitalize">{{ $m->category }}</td>
      <td>Rp {{ number_format($m->price,0,',','.') }}</td>
      <td class="text-end">
        <a href="{{ route('menus.edit',$m) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('menus.destroy',$m) }}" method="post" class="d-inline"
              onsubmit="return confirm('Hapus menu?')">@csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Hapus</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $menus->links() }}
@endsection
