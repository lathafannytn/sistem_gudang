<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    // Tampilkan halaman index
    public function index()
    {
        return view('user.index');
    }

    // Metode untuk menyediakan data ke DataTables
    public function tableDataAdmin()
    {
        if (request()->ajax()) {
            $users = User::query()->orderBy('id', 'desc');

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('Action', function ($user) {
                    return '
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="' . route('user.edit', $user->id) . '">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                            </div>
                        </div>
                    ';
                })
                ->rawColumns(['Action'])
                ->make(true);
        }
    }

    // Tampilkan halaman create
    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Save user to the database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Return a success response in JSON format
        return response()->json(['status' => 'success', 'msg' => 'User berhasil ditambahkan']);
    }


        

    // Tampilkan halaman edit
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    // Update data user
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed', 
        ]);

        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;

        // Jika password diisi, maka update password
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Simpan perubahan
        $user->save();

        // Kirimkan respons success
        return response()->json(['status' => 'success', 'msg' => 'User berhasil diperbarui']);
    }

}
