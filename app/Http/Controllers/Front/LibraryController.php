<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $search = $request->input('search');

        // Ambil Item Order milik user yang statusnya 'completed'
        $query = OrderItem::whereHas('order', function($q) use ($userId) {
            $q->where('user_id', $userId)
              ->where('status', 'completed');
        })->with('product');

        // Fitur Search Sederhana
        if ($search) {
            $query->whereHas('product', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // Urutkan berdasarkan nama produk (A-Z) biar seperti Library beneran
        $myGames = $query->get()->sortBy(function($item) {
            return $item->product->name;
        });

        return view('front.library.index', compact('myGames'));
    }
}