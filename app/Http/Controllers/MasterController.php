<?php

namespace App\Http\Controllers;

use App\Http\Requests\addEmployee;
use App\Models\UserAuth;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

use function Laravel\Prompts\error;

class MasterController extends Controller
{
    public function employees(Request $request)
    {
        $attr = [
            'title' => 'Employees',
            'fullname' => $request->session()->get('userdetail')['fullname'],
            'position' => $request->session()->get('userdetail')['position'],
            'role_list' => ['administrator', 'user'],
            'employees' => UserDetail::all()
        ];
        $title = 'Hapus Karyawan';
        $text = 'Apakah anda yakin ingin menghapus data karyawan ini?';
        confirmDelete($title, $text);
        return view('masters.employees', $attr);
    }
    public function addEmployee(Request $request)
    {
        // if ($request->validated()) {
        //     $validated = $request->validated();
        //     $userauth = [
        //         'username' => $validated['username'],
        //         'password' => Hash::make(12345678),
        //         'frp' => 0,
        //         'role' => $validated['role']
        //     ];
        //     $userdetail = [
        //         'nik' => $validated['nik'],
        //         'username' => $validated['username'],
        //         'fullname' => $validated['fullname'],
        //         'position' => $validated['position']
        //     ];
        //     UserAuth::create($userauth);
        //     UserDetail::create($userdetail);
        //     Alert::success('Sukses', 'Data karyawan berhasil ditambahkan');
        // } else {
        //     Alert::error('Gagal', 'Data karyawan gagal ditambahkan');
        // }
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required|alpha:ascii|lowercase|unique:App\Models\UserAuth,username',
                'nik' => 'required|numeric',
                'fullname' => 'required|regex:/^[a-zA-Z\s]+$/',
                'position' => 'required|regex:/^[a-zA-Z\s]+$/',
                'role' => 'required'
            ],
            [
                'username.required' => 'username belum diisi',
                'username.alpha' => 'username hanya boleh berisi huruf a-z',
                'username.lowercase' => 'username hanya boleh berisi huruf kecil',
                'username.unique' => 'username sudah terdaftar',
                'fullname.required' => 'nama lengkap belum diisi',
                'fullname.regex' => 'nama lengkap hanya boleh berisi huruf a-z',
                'position.required' => 'posisi belum diisi',
                'position.regex' => 'posisi hanya boleh berisi huruf a-z',
                'role.required' => 'role belum dipilih'
            ]
        );
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->all());
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
