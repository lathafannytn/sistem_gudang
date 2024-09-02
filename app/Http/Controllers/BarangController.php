<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Lokasi;
use App\Models\Kategori;
use App\Models\Barang;
use Yajra\DataTables\DataTables;



class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('barang.index');
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'msg' => 'Gagal memuat halaman', 'err' => $e->getMessage()], 500);
        }
    }

    public function tableDataAdmin()
    {
        if (request()->ajax()) {
            $query = Barang::with(['kategori', 'lokasi'])->orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('Kode', function ($item) {
                    return $item->kode;
                })
                ->addColumn('Nama', function ($item) {
                    return $item->nama;
                })
                ->addColumn('Stok', function ($item) {
                    return $item->stok;
                })
                ->addColumn('Deskripsi', function ($item) {
                    return $item->deskripsi;
                })
                ->addColumn('Kategori', function ($item) {
                    return $item->kategori ? $item->kategori->nama : 'Tidak Ada Kategori';
                })
                ->addColumn('Lokasi', function ($item) {
                    return $item->lokasi ? $item->lokasi->nama : 'Tidak Ada Lokasi';
                })
                ->addColumn('Action', function ($item) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="' . route('barang.edit', $item->id) . '">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="deleteData(' . $item->id . ')">
                                    <i class="bx bx-trash me-1"></i> Delete
                                </a>
                            </div>
                        </div>
                    ';
                })
                ->rawColumns(['Action'])
                ->make(true);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $kategoris = Kategori::all();
            $lokasis = Lokasi::all();
            
            // Generate kode barang otomatis
            $lastBarang = Barang::orderBy('id', 'desc')->first();
            $newKode = 'BRG' . str_pad(optional($lastBarang)->id + 1, 3, '0', STR_PAD_LEFT); 

            return view('barang.create', compact('kategoris', 'lokasis', 'newKode'));
        } catch (\Exception $e) {
            return redirect()->route('barang.index')->with('error', 'Gagal memuat halaman Tambah Barang: ' . $e->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'kode' => 'required|unique:barangs,kode',
                'nama' => 'required|string|max:255',
                'stok' => 'required|integer|min:0',
                'deskripsi' => 'nullable|string',
                'kategori_id' => 'required|exists:kategoris,id',
                'lokasi_id' => 'required|exists:lokasis,id',
            ]);

            Barang::create($request->all());

            return response()->json(['status' => 'success', 'msg' => 'Berhasil Tambah Barang'], 201);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['status' => 'error', 'msg' => 'Gagal Tambah Barang. Silakan coba lagi.'], 500);
        }
    }

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $barang = Barang::findOrFail($id);
            return view('barang.show', compact('barang'));
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'msg' => 'Barang tidak ditemukan', 'err' => $e->getMessage()], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $barang = Barang::findOrFail($id);
            $kategoris = Kategori::all();
            $lokasis = Lokasi::all();

            return view('barang.edit', compact('barang', 'kategoris', 'lokasis'));
        } catch (\Exception $e) {
            return redirect()->route('barang.index')->with('error', 'Gagal memuat halaman edit: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'kode' => 'required|string|max:255',
                'nama' => 'required|string|max:255',
                'stok' => 'required|integer|min:0',
                'deskripsi' => 'nullable|string',
                'kategori_id' => 'required|exists:kategoris,id',
                'lokasi_id' => 'required|exists:lokasis,id',
            ]);

            $barang = Barang::findOrFail($id);
            $barang->update($request->all());

            return response()->json(['status' => 'success', 'msg' => 'Berhasil Ubah Barang'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'msg' => 'Gagal Ubah Barang: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $barang = Barang::findOrFail($id);
            $barang->delete();
            return response()->json(['status' => 'success', 'msg' => 'Berhasil Hapus Barang'], 200);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'msg' => 'Gagal Hapus Barang', 'err' => $e->getMessage()], 500);
        }
    }
}
