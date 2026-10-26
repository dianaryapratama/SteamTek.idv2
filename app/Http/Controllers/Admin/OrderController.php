<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        // Tampilkan pesanan terbaru di atas
        $orders = Order::latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product', 'paymentMethod')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // LOGIKA TERIMA PESANAN
    public function confirmOrder($id)
    {
        $order = Order::findOrFail($id);

        // Update status jadi completed
        // Generate Token Download agar user bisa download
        $order->update([
            'status' => 'completed',
            'download_token' => Str::random(64), // Token acak yang aman
            'is_download_blocked' => false
        ]);

        return redirect()->back()->with('success', 'Pesanan diterima! Link download telah digenerate.');
    }
}