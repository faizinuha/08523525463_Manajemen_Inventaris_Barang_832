<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
{
    $suppliers = Supplier::orderBy('created_at', 'desc') // Urutkan berdasarkan waktu pembuatan terbaru
        ->get();  // Mengambil semua data supplier
    
    return view('Crud_admin.Supplier.index', compact('suppliers'));
}

    public function create()
    {
        return view('Crud_admin.Supplier.create');
    }
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_supplier' => 'required|string|max:255|unique:suppliers,nama_supplier',
            'alamat' => 'required|string',
            'kontak' => 'nullable|string|max:255|regex:/^[0-9]{9,15}$/', // Validasi nomor telepon
        ], [
            'nama_supplier.unique' => 'Nama Supplier sudah ada.',
            'kontak.regex' => 'Format nomor kontak tidak valid.', // Pesan error regex kontak
        ]);
        
    
        try {
            // Membuat data supplier baru
            Supplier::create($validated);
            return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('suppliers.index')->with('error', 'Terjadi kesalahan saat menambahkan supplier.');
        }
    }
    
    public function edit(Supplier $supplier)
    {
        return view('Crud_admin.Supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_supplier' => 'required|string|max:255|unique:suppliers , nama_supplier,' . $supplier->id,
            'alamat' => 'required|string',
            'kontak' => 'nullable|string|max:255',
        ]);
    
        try {
            // Update data supplier
            $supplier->update($validated);
            return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('suppliers.index')->with('error', 'Terjadi kesalahan saat memperbarui supplier.');
        }
    }
    
    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
            return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('suppliers.index')->with('error', 'Terjadi kesalahan saat menghapus supplier.');
        }
    }
}
