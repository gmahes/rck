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
            'division_list' => ['Operasional', 'Non Operasional'],
            'role_list' => ['administrator', 'user'],
            'employees' => UserDetail::join('user_auth', 'user_detail.username', '=', 'user_auth.username')
                ->where('user_auth.role', '!=', 'superadmin')
                ->orderBy('user_detail.fullname')
                ->get(['user_detail.*'])
        ];
        return view('masters.employees', $attr);
    }
    public function addEmployee(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required|unique:App\Models\UserAuth,username|alpha:ascii|lowercase',
                'nik' => 'required|numeric|unique:App\Models\UserDetail,nik',
                'fullname' => 'required|regex:/^[a-zA-Z\s]+$/',
                'position' => 'required|regex:/^[a-zA-Z\s]+$/',
                'division' => 'required',
            ],
            [
                'username.required' => 'Username belum diisi',
                'username.alpha' => 'Username hanya boleh berisi huruf a-z. Anda membuat ' . "'$request->username'",
                'username.lowercase' => 'Username hanya boleh berisi huruf kecil. Anda membuat ' . "'$request->username'",
                'username.unique' => 'Username sudah terdaftar',
                'nik.required' => 'NIK belum diisi',
                'nik.numeric' => 'NIK hanya boleh berisi angka. Anda membuat ' . "'$request->nik'",
                'nik.unique' => 'NIK sudah terdaftar',
                'fullname.required' => 'Nama lengkap belum diisi',
                'fullname.regex' => 'Nama lengkap hanya boleh berisi huruf a-z. Anda membuat ' . "'$request->fullname'",
                'position.required' => 'Posisi belum diisi',
                'position.regex' => 'Posisi hanya boleh berisi huruf a-z. Anda membuat ' . "'$request->position'",
                'division.required' => 'Divisi belum dipilih'
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
            'role' => $request->role
        ];
        $userdetail = [
            'nik' => $validated['nik'],
            'username' => $validated['username'],
            'fullname' => $validated['fullname'],
            'position' => $validated['position'],
            'division' => $validated['division']
        ];
        UserAuth::create($userauth);
        UserDetail::create($userdetail);
        Alert::success('Sukses', 'Data karyawan berhasil ditambahkan');
        return redirect()->route('employees');
    }
    public function editEmployee(Request $request, $username)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'fullname' => 'required|regex:/^[a-zA-Z\s]+$/',
                'position' => 'required|regex:/^[a-zA-Z\s]+$/',
                'division' => 'required',
            ],
            [
                'fullname.required' => 'Nama lengkap belum diisi',
                'fullname.regex' => 'Nama lengkap hanya boleh berisi huruf a-z. Anda membuat ' . "'$request->fullname'",
                'position.required' => 'Posisi belum diisi',
                'position.regex' => 'Posisi hanya boleh berisi huruf a-z. Anda membuat ' . "'$request->position'",
                'division.required' => 'Divisi belum dipilih'
            ],
        );
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('employees');
        }
        $validated = $validator->validated();
        if (!$request->role) {
            $userdetail = [
                'fullname' => $validated['fullname'],
                'position' => $validated['position'],
                'division' => $validated['division']

            ];
        } else {
            $userauth = [
                'role' => $request->role
            ];
            UserAuth::where('username', $username)->update($userauth);
            $userdetail = [
                'fullname' => $validated['fullname'],
                'position' => $validated['position'],
                'division' => $validated['division'],
            ];
        }
        UserDetail::where('username', $username)->update($userdetail);
        Alert::success('Sukses', 'Data karyawan berhasil diubah');
        return redirect()->route('employees');
    }
    public function delEmployee($username)
    {
        UserAuth::where('username', $username)->delete();
        UserDetail::where('username', $username)->delete();
        Alert::success('Sukses', 'Data karyawan berhasil dihapus');
        return redirect()->route('employees');
    }
    public function resetPassword($username)
    {
        $userauth = UserAuth::where('username', $username)->first();
        $userauth->update(['password' => Hash::make(12345678)]);
        Alert::success('Sukses', 'Password berhasil direset');
        return redirect()->route('employees');
    }
    public function drivers()
    {
        $attr = [
            'title' => 'Supir dan Kernet',
        ];
        return view('masters.drivers', $attr);
    }
}
