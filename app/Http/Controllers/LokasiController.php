<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Lokasi;
use Yajra\DataTables\DataTables;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return view('lokasi.index');
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
            $lokasis = Lokasi::orderBy('id', 'desc')->get();

            return DataTables::of($lokasis)
                ->addIndexColumn() 
                ->addColumn('Action', function ($lokasi) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="' . route('lokasi.edit', $lokasi->id) . '">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                <a href="javascript:void(0);" class="dropdown-item delete-btn" data-id="' . $lokasi->id . '">
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
        return view('lokasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|unique:lokasis|max:255',
                'lokasi' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'msg' => 'Validasi gagal', 'errors' => $validator->errors()], 422);
            }

            Lokasi::create($request->only('nama', 'lokasi'));
            return response()->json(['status' => 'success', 'msg' => 'Berhasil Tambah Lokasi'], 201);
        } catch (\Exception $e) {
            \Log::error('Gagal tambah lokasi', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'msg' => 'Gagal Tambah Lokasi', 'err' => $e->getMessage()], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $lokasi = Lokasi::findOrFail($id);
            return view('lokasi.edit', compact('lokasi'));
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'msg' => 'Lokasi tidak ditemukan', 'err' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255|unique:lokasis,nama,' . $id,
                'lokasi' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'msg' => 'Gagal Ubah Lokasi', 'err' => $validator->errors()], 200);
            }

            $lokasi = Lokasi::findOrFail($id);
            $lokasi->update($request->only('nama', 'lokasi'));
            return response()->json(['status' => 'success', 'msg' => 'Berhasil Ubah Lokasi'], 200);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'msg' => 'Gagal Ubah Lokasi', 'err' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $lokasi = Lokasi::findOrFail($id);
            $lokasi->delete();
            return response()->json(['status' => 'success', 'msg' => 'Berhasil Hapus Lokasi'], 200);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'msg' => 'Gagal Hapus Lokasi', 'err' => $e->getMessage()], 500);
        }
    }
}
