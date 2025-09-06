<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;



class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::withCount('items')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $menus = Menu::orderBy('category')->orderBy('name')->get();
        return view('orders.create', compact('menus'));
    }

    public function store(Request $request)
    {
        // Validasi form + minimal 1 item
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'table_number'  => 'required|integer|min:1',
            'items'         => 'required|array|min:1',
            'items.*.menu_id'  => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
        ],[
            'items.required' => 'Pesanan harus memiliki minimal 1 menu.'
        ]);

        $items = collect($request->input('items'))->values();

        // Hitung ulang di server (jangan percaya JS)
        $menus = Menu::whereIn('id', $items->pluck('menu_id'))->get()->keyBy('id');
        $total = 0;

        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'table_number'  => $request->table_number,
                'total_price'   => 0,
            ]);

            foreach ($items as $row) {
                $menu = $menus[$row['menu_id']];
                $qty  = (int) $row['quantity'];
                $subtotal = $menu->price * $qty;
                $total += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id'  => $menu->id,
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                ]);
            }

            $order->update(['total_price'=>$total]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('orders.show', $order)->with('ok','Pesanan berhasil dibuat.');
    }

    public function show(Order $order)
    {
        $order->load('items.menu');
        return view('orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('ok','Pesanan dihapus.');
    }

    public function print(Order $order)
    {
        $order->load('items.menu');

        if (!View::exists('orders.receipt')) {
            abort(404, 'Template struk tidak ditemukan.');
        }

        $pdf = Pdf::loadView('orders.receipt', compact('order'));
        return $pdf->download('struk_pesanan_' . $order->id . '.pdf');
    }
}
