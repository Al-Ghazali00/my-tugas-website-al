@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Daftar Pesanan</h3>
  <a href="{{ route('orders.create') }}" class="btn btn-primary">Pesanan Baru</a>
</div>
<table class="table table-striped">
  <thead><tr>
    <th>#</th><th>Pelanggan</th><th>Meja</th><th>Item</th><th>Total</th><th>Tanggal</th><th></th>
  </tr></thead>
  <tbody>
  @foreach($orders as $o)
    <tr>
      <td>{{ $o->id }}</td>
      <td>{{ $o->customer_name }}</td>
      <td>{{ $o->table_number }}</td>
      <td>{{ $o->items_count }}</td>
      <td>Rp {{ number_format($o->total_price,0,',','.') }}</td>
      <td>{{ $o->created_at->format('d/m/Y H:i') }}</td>
      <td class="text-end">
        <a href="{{ route('orders.show',$o) }}" class="btn btn-sm btn-info">Detail</a>
        <form action="{{ route('orders.destroy',$o) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus pesanan?')">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger">Hapus</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $orders->links() }}
@endsection
