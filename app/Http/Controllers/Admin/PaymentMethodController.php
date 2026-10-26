<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::all();
        return view('admin.payment_methods.index', compact('methods'));
    }

    public function create()
    {
        return view('admin.payment_methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:transfer,qris,ewallet',
            'account_number' => 'nullable|string',
            'account_holder' => 'nullable|string',
            'qris_image' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $data = $request->all();
        $data['is_active'] = true; // Default aktif

        if ($request->hasFile('qris_image')) {
            $data['qris_image'] = $request->file('qris_image')->store('payments', 'public');
        }

        PaymentMethod::create($data);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran ditambahkan.');
    }

    public function edit($id)
    {
        $method = PaymentMethod::findOrFail($id);
        return view('admin.payment_methods.edit', compact('method'));
    }

    public function update(Request $request, $id)
    {
        $method = PaymentMethod::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:transfer,qris,ewallet',
            'qris_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        // Checkbox handling (jika tidak dicentang, tidak terkirim di request)
        $data['is_active'] = $request->has('is_active'); 

        if ($request->hasFile('qris_image')) {
            // Hapus gambar lama jika ada
            if ($method->qris_image) {
                Storage::disk('public')->delete($method->qris_image);
            }
            $data['qris_image'] = $request->file('qris_image')->store('payments', 'public');
        }

        $method->update($data);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Data diperbarui.');
    }

    public function destroy($id)
    {
        $method = PaymentMethod::findOrFail($id);
        if ($method->qris_image) {
            Storage::disk('public')->delete($method->qris_image);
        }
        $method->delete();
        return redirect()->back()->with('success', 'Metode pembayaran dihapus.');
    }
}