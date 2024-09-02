<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Kategori;
use Yajra\DataTables\DataTables;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('kategori.index');
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'msg' => 'Gagal memuat halaman', 'err' => $e->getMessage()], 500);
        }
    }

    /**
     * Display data for DataTables server-side.
     */
    public function tableDataAdmin()
    {
        if (request()->ajax()) {
            $kategoris = Kategori::orderBy('id', 'desc')->get();

            return DataTables::of($kategoris)
                ->addIndexColumn()
                ->addColumn('Action', function ($kategori) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="' . route('kategori.edit', $kategori->id) . '">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                <a href="javascript:void(0);" class="dropdown-item delete-btn" data-id="' . $kategori->id . '">
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
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|unique:kategoris|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'msg' => 'Gagal Tambah Kategori', 'err' => 'Harap Periksa Kembali Inputan', 'valid' => $validator->errors()], 200);
            } else {
                Kategori::create($request->only('nama'));
                return response()->json(['status' => 'success', 'msg' => 'Berhasil Tambah Kategori'], 201);
            }
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'msg' => 'Gagal Tambah Kategori', 'err' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            return view('kategori.edit', compact('kategori'));
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'msg' => 'Kategori tidak ditemukan', 'err' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255|unique:kategoris,nama,' . $id,
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'msg' => 'Gagal Ubah Kategori', 'err' => 'Harap Periksa Kembali Inputan', 'valid' => $validator->errors()], 200);
            } else {
                $kategori = Kategori::findOrFail($id);
                $kategori->update($request->only('nama'));
                return response()->json(['status' => 'success', 'msg' => 'Berhasil Ubah Kategori'], 200);
            }
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'msg' => 'Gagal Ubah Kategori', 'err' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();
            return response()->json(['status' => 'success', 'msg' => 'Berhasil Hapus Kategori'], 200);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'msg' => 'Gagal Hapus Kategori', 'err' => $e->getMessage()], 500);
        }
    }
}
