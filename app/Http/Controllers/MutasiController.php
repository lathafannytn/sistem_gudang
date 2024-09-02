<?php
namespace App\Http\Controllers;

use App\Models\Mutasi;
use App\Models\User;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mutasi.index');
    }

    /**
     * Method to provide data for DataTables.
     */
    public function tableDataAdmin()
    {
        if (request()->ajax()) {
            $mutasis = Mutasi::with(['user', 'barang'])->orderBy('id', 'desc');

            return DataTables::of($mutasis)
                ->addIndexColumn()
                ->addColumn('tanggal', function ($mutasi) {
                    return $mutasi->tanggal;
                })
                ->addColumn('jenis_mutasi', function ($mutasi) {
                    return $mutasi->jenis_mutasi;
                })
                ->addColumn('jumlah', function ($mutasi) {
                    return $mutasi->jumlah;
                })
                ->addColumn('user', function ($mutasi) {
                    return $mutasi->user ? $mutasi->user->name : 'Tidak Ada User';
                })
                ->addColumn('barang', function ($mutasi) {
                    return $mutasi->barang ? $mutasi->barang->nama : 'Tidak Ada Barang';
                })
                ->addColumn('Action', function ($mutasi) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="' . route('mutasi.edit', $mutasi->id) . '">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                <a class="dropdown-item delete-btn" href="javascript:void(0);" data-id="' . $mutasi->id . '">
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
        $users = User::all();
        $barangs = Barang::all();
        return view('mutasi.create', compact('users', 'barangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    
    // Inside the store method
    public function store(Request $request)
    {
        try {
            $request->validate([
                'jenis_mutasi' => 'required|in:Penambahan Stok,Pengurangan Stok',
                'jumlah' => 'required|integer|min:1',
                'barangs_id' => 'required|exists:barangs,id',
                'users_id' => 'required|exists:users,id',
            ]);

            $tanggal = Carbon::now()->format('Y-m-d');

            $barang = Barang::findOrFail($request->barangs_id);

            if ($request->jenis_mutasi === 'Penambahan Stok') {
                $barang->stok += $request->jumlah;
            } elseif ($request->jenis_mutasi === 'Pengurangan Stok') {
                if ($barang->stok < $request->jumlah) {
                    return response()->json(['status' => 'error', 'msg' => 'Stok tidak mencukupi untuk pengurangan.'], 400);
                }
                $barang->stok -= $request->jumlah; 
            }

            $barang->save();

            Mutasi::create([
                'tanggal' => $tanggal,
                'jenis_mutasi' => $request->jenis_mutasi,
                'jumlah' => $request->jumlah,
                'barangs_id' => $request->barangs_id,
                'users_id' => Auth::id(),
            ]);

            return response()->json(['status' => 'success', 'msg' => 'Mutasi berhasil ditambahkan dan stok barang diperbarui.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'msg' => 'Gagal menambahkan mutasi.', 'err' => $e->getMessage()], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $mutasi = Mutasi::findOrFail($id);
        $users = User::all();
        $barangs = Barang::all();
        return view('mutasi.edit', compact('mutasi', 'users', 'barangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'jenis_mutasi' => 'required|in:Penambahan Stok,Pengurangan Stok',
            'jumlah' => 'required|integer',
            'barangs_id' => 'required|exists:barangs,id',
            'users_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'msg' => 'Validasi gagal', 'errors' => $validator->errors()], 422);
        }

        $mutasi = Mutasi::findOrFail($id);
        $mutasi->update($request->all());
        return response()->json(['status' => 'success', 'msg' => 'Mutasi berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $mutasi = Mutasi::findOrFail($id);
        $mutasi->delete();
        return response()->json(['status' => 'success', 'msg' => 'Mutasi berhasil dihapus']);
    }
}
