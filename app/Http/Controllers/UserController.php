<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('pages.user.index', compact('users'));
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('user')->with('success', 'Berhasil menambahkan data user');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function edit(String $id)
    {
        $user = User::find($id);
        return view('pages.user.edit', compact('user'));
    }

    public function editProcess(Request $request, String $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        try {
            $user = User::find($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return redirect()->route('user')->with('success', 'Berhasil mengubah data user');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah data: ' . $e->getMessage());
        }
    }

    public function delete(String $id)
    {
        try {
            $user = User::find($id);
            $user->delete();

            return redirect()->route('user')->with('success', 'Berhasil menghapus data user');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function changePasswordShowPage()
    {
        return view('pages.user.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ], [
            'confirm_password.same' => 'Password baru dan konfirmasi password baru tidak sama',
        ]);

        try {
            $user = User::find(auth()->user()->id);
            if (!Hash::check($request->old_password, $user->password)) {
                return redirect()->back()->with('error', 'Password lama tidak sesuai');
            }

            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            return redirect()->route('user')->with('success', 'Berhasil mengubah password');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah password: ' . $e->getMessage());
        }
    }
}
