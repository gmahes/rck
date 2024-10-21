<?php

namespace App\Http\Controllers;

use App\Models\UserAuth;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class MasterController extends Controller
{
    public function employees(Request $request)
    {
        $attr = [
            'title' => 'Employees',
            'fullname' => $request->session()->get('userdetail')['fullname'],
            'position' => $request->session()->get('userdetail')['position'],
            'role_list' => ['administrator', 'user'],
            'employees' => UserDetail::all()->sortBy('fullname')
        ];
        $title = 'Hapus Karyawan';
        $text = 'Apakah anda yakin ingin menghapus data karyawan ini?';
        confirmDelete($title, $text);
        return view('masters.employees', $attr);
    }
    public function addEmployee(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required|unique:App\Models\UserAuth,username|alpha:ascii|lowercase',
                'nik' => 'required|numeric',
                'fullname' => 'required|regex:/^[a-zA-Z\s]+$/',
                'position' => 'required|regex:/^[a-zA-Z\s]+$/',
                'role' => 'required'
            ],
            [
                'username.required' => 'Username belum diisi',
                'username.alpha' => 'Username hanya boleh berisi huruf a-z. Anda membuat ' . "'$request->username'",
                'username.lowercase' => 'Username hanya boleh berisi huruf kecil. Anda membuat ' . "'$request->username'",
                'username.unique' => 'Username sudah terdaftar',
                'fullname.required' => 'Nama lengkap belum diisi',
                'fullname.regex' => 'Nama lengkap hanya boleh berisi huruf a-z. Anda membuat ' . "'$request->fullname'",
                'position.required' => 'Posisi belum diisi',
                'position.regex' => 'Posisi hanya boleh berisi huruf a-z. Anda membuat ' . "'$request->position'",
                'role.required' => 'Role belum dipilih'
            ],
        );
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('employees');
        }
        $validated = $validator->validated();
        $userauth = [
            'username' => $validated['username'],
            'password' => Hash::make(12345678),
            'frp' => 0,
            'role' => $validated['role']
        ];
        $userdetail = [
            'nik' => $validated['nik'],
            'username' => $validated['username'],
            'fullname' => $validated['fullname'],
            'position' => $validated['position']
        ];
        UserAuth::create($userauth);
        UserDetail::create($userdetail);
        Alert::success('Sukses', 'Data karyawan berhasil ditambahkan');
        return redirect()->route('employees');
    }
    public function delEmployee($username)
    {
        UserAuth::where('username', $username)->delete();
        UserDetail::where('username', $username)->delete();
        Alert::success('Sukses', 'Data karyawan berhasil dihapus');
        return redirect()->route('employees');
    }
}
