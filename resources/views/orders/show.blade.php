@extends('layouts.app')
@section('content')
<h3>Detail Pesanan #{{ $order->id }}</h3>
<p class="mb-1"><strong>Pelanggan:</strong> {{ $order->customer_name }}</p>
<p class="mb-1"><strong>Meja:</strong> {{ $order->table_number }}</p>
<p class="mb-3"><strong>Tanggal:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>

<table class="table">
  <thead><tr><th>Menu</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr></thead>
  <tbody>
  @foreach($order->items as $it)
    <tr>
      <td>{{ $it->menu->name }}</td>
      <td>Rp {{ number_format($it->menu->price,0,',','.') }}</td>
      <td>{{ $it->quantity }}</td>
      <td>Rp {{ number_format($it->subtotal,0,',','.') }}</td>
    </tr>
  @endforeach
  </tbody>
  <tfoot>
    <tr><th colspan="3" class="text-end">Total</th>
        <th>Rp {{ number_format($order->total_price,0,',','.') }}</th></tr>
  </tfoot>
</table>

<a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
<a href="{{ route('orders.print', $order) }}" class="btn btn-success" target="_blank">Cetak Struk</a>
@endsection
