@extends('layouts.app')
@section('content')
<h3>Buat Pesanan</h3>

<form method="post" action="{{ route('orders.store') }}" id="order-form">@csrf
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Nama Pelanggan</label>
      <input name="customer_name" class="form-control" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Nomor Meja</label>
      <input name="table_number" type="number" min="1" class="form-control" required>
    </div>
  </div>

  <hr>
  <div class="d-flex justify-content-between align-items-center mb-2">
    <h5>Item Pesanan</h5>
    <button type="button" class="btn btn-sm btn-outline-primary" id="add-row">+ Tambah Item</button>
  </div>

  <div class="table-responsive">
  <table class="table" id="items-table">
    <thead>
      <tr><th style="width:45%">Menu</th><th style="width:15%">Harga</th><th style="width:15%">Qty</th><th style="width:15%">Subtotal</th><th style="width:10%"></th></tr>
    </thead>
    <tbody></tbody>
    <tfoot>
      <tr>
        <th colspan="3" class="text-end">Total</th>
        <th id="grand-total">Rp 0</th>
        <th></th>
      </tr>
    </tfoot>
  </table>
  </div>

  <button class="btn btn-success">Simpan Pesanan</button>
</form>

@php
// kirim data menu ke JS
$menusJson = $menus->map(fn($m)=>[
  'id'=>$m->id,'name'=>$m->name,'price'=>$m->price,
  'text'=>$m->name.' ('.ucfirst($m->category).')'
])->values();
@endphp
@endsection

@push('scripts')
<script>
const MENUS = @json($menusJson);
const tbody = document.querySelector('#items-table tbody');
const fmt = n => new Intl.NumberFormat('id-ID').format(n);

function menuSelectHTML(idx){
  let opt = MENUS.map(m => `<option value="${m.id}" data-price="${m.price}">${m.text}</option>`).join('');
  return `<select name="items[${idx}][menu_id]" class="form-select menu-select" required>${opt}</select>`;
}
function rowHTML(idx){
  return `<tr>
    <td>${menuSelectHTML(idx)}</td>
    <td class="price">0</td>
    <td><input name="items[${idx}][quantity]" type="number" min="1" value="1" class="form-control qty"></td>
    <td class="subtotal">0</td>
    <td><button type="button" class="btn btn-sm btn-outline-danger del">Hapus</button></td>
  </tr>`;
}
function recalc(){
  let total = 0;
  tbody.querySelectorAll('tr').forEach(tr=>{
    const select = tr.querySelector('.menu-select');
    const price  = Number(select.selectedOptions[0].dataset.price || 0);
    tr.querySelector('.price').innerText = 'Rp ' + fmt(price);
    const qty    = Number(tr.querySelector('.qty').value || 0);
    const sub    = price * qty;
    tr.querySelector('.subtotal').innerText = 'Rp ' + fmt(sub);
    total += sub;
  });
  document.querySelector('#grand-total').innerText = 'Rp ' + fmt(total);
}
function bind(tr){
  tr.querySelector('.menu-select').addEventListener('change', recalc);
  tr.querySelector('.qty').addEventListener('input', recalc);
  tr.querySelector('.del').addEventListener('click', ()=>{ tr.remove(); recalc(); });
  recalc();
}
document.getElementById('add-row').addEventListener('click', ()=>{
  const idx = tbody.querySelectorAll('tr').length;
  tbody.insertAdjacentHTML('beforeend', rowHTML(idx));
  bind(tbody.lastElementChild);
});
// buat 1 baris awal
document.getElementById('add-row').click();
</script>
@endpush
