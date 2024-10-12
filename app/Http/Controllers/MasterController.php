<?php

namespace App\Http\Controllers;

use App\Http\Requests\addEmployee;
use App\Models\UserAuth;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
            'employees' => UserDetail::all()
        ];
        return view('masters.employees', $attr);
    }
    public function addEmployee(addEmployee $request)
    {
        $validated = $request->validated();
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
}
