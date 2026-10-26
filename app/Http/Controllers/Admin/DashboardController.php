<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung statistik
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $pendingOrders = Order::whereIn('status', ['pending', 'waiting_validation'])->count();
        $totalProducts = Product::count();
        $recentOrders = Order::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalRevenue', 'pendingOrders', 'totalProducts', 'recentOrders'));
    }
}