<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        // Tampilkan yang terbaru dulu
        $complaints = Complaint::latest()->paginate(10);
        return view('admin.complaints.index', compact('complaints'));
    }

    public function update(Request $request, $id)
    {
        // Tandai sebagai selesai
        $complaint = Complaint::findOrFail($id);
        $complaint->update(['is_resolved' => true]);
        
        return redirect()->back()->with('success', 'Komplain ditandai selesai.');
    }

    public function destroy($id)
    {
        Complaint::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Komplain dihapus.');
    }
}