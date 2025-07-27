<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Level;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('level')->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $levels = Level::all();
        return view('user.create', compact('levels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|max:10|unique:user,id_user',
            'username' => 'required|max:50|unique:user,username',
            'password' => 'required|min:6',
            'nama_admin' => 'required|max:100',
            'id_level' => 'required|exists:level,id_level',
        ]);
        User::create([
            'id_user' => $request->input('id_user'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'nama_admin' => $request->input('nama_admin'),
            'id_level' => $request->input('id_level'),
        ]);
        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $levels = Level::all();
        return view('user.edit', compact('user','levels'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'username' => 'required|max:50|unique:user,username,'.$id.',id_user',
            'nama_admin' => 'required|max:100',
            'id_level' => 'required|exists:level,id_level',
        ]);
        $data = [
            'username' => $request->input('username'),
            'nama_admin' => $request->input('nama_admin'),
            'id_level' => $request->input('id_level'),
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }
        $user->update($data);
        return redirect()->route('user.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy($id)
    {
        try {
            User::destroy($id);
            return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->route('user.index')->with('error', 'User tidak bisa dihapus karena masih digunakan pada data pembayaran.');
            }
            throw $e;
        }
    }
}
