@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: auto; padding: 20px; font-family: Arial, sans-serif; font-size: 12px;">

    <div class="text-center mb-4">
        <h2>Struk Pesanan</h2>
        <p>Restoran Filo POS</p>
    </div>

    <div class="mb-4">
        <p><strong>No. Pesanan:</strong> {{ $order->id }}</p>
        <p><strong>Pelanggan:</strong> {{ $order->customer_name }}</p>
        <p><strong>Meja:</strong> {{ $order->table_number }}</p>
        <p><strong>Tanggal:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Menu</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->menu->name }}</td>
                <td>Rp {{ number_format($item->menu->price, 0, ',', '.') }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end fw-bold">Total</td>
                <td class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="text-center mt-4">
        <p>Terima Kasih atas Kunjungan Anda!</p>
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

</div>
@endsection
