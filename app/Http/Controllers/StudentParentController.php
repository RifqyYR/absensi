<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParentStudentDataRequest;
use App\Models\StudentParent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentParentController extends Controller
{
    public function index()
    {
        $parents = StudentParent::all();
        return view('pages.parent.index', ['parents' => $parents]);
    }

    public function create()
    {
        return view('pages.parent.create');
    }

    public function store(StoreParentStudentDataRequest $request)
    {
        $data = $request->validated();
        $password = Hash::make(env('DEFAULT_PASSWORD'));

        try {
            DB::transaction(function () use ($data, $password) {
                StudentParent::create([
                    'name' => $data['nama'],
                    'username' => $this->getUniqueUsername(strtolower($data['nama'])),
                    'phone_number' => $data['phone_number'],
                    'password' => $password,
                ]);
            });

            return redirect()->route('parent-data')->with('success', 'Berhasil menambahkan data baru');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    protected function getUniqueUsername($name)
    {
        $nameParts = explode(" ", $name);
        $nameParts = array_filter($nameParts);
        $username = implode("", $nameParts);
        $i = 1;

        while (StudentParent::where('username', $username)->exists()) {
            $username .= $i;
            $i++;
        }

        return $username;
    }

    public function delete(string $uuid)
    {
        try {
            DB::transaction(function () use ($uuid) {
                StudentParent::where('uuid', $uuid)->delete();
            });

            return redirect()->route('parent-data')->with('success', 'Berhasil menghapus data');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function edit(string $uuid)
    {
        $parent = StudentParent::where('uuid', $uuid)->first();
        return view('pages.parent.edit', ['parent' => $parent]);
    }

    public function editProcess(Request $request, string $uuid)
    {
        $this->validate($request, [
            'nama' => 'required',
            'username' => 'required',
            'phone_number' => 'nullable',
        ]);

        $data = $request->all();

        try {
            DB::transaction(function () use ($data, $uuid) {
                StudentParent::where('uuid', $uuid)->update([
                    'name' => $data['nama'],
                    'username' => strtolower($data['username']),
                    'phone_number' => $data['phone_number'],
                ]);
            });

            return redirect()->route('parent-data')->with('success', 'Berhasil mengubah data');
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal mengubah data: ' . $e->getMessage());
        }
    }
}
