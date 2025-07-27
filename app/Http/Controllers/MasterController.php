<?php

namespace App\Http\Controllers;

use App\Models\ComplaintCategories;
use App\Models\Positions;
use App\Models\UserAuth;
use App\Models\UserDetail;
use GuzzleHttp\Psr7\Query;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;


class MasterController extends Controller
{
    public function employees(Request $request)
    {
        $attr = [
            'title' => 'Data Karyawan',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'role_list' => ['administrator', 'user'],
            'employees' => UserDetail::join('user_auth', 'user_detail.username', '=', 'user_auth.username')
                ->where('user_auth.role', '!=', 'superadmin')
                ->orderBy('user_detail.fullname')
                ->get(['user_detail.*']),
            'positions' => Positions::all()->sortBy('name'),
        ];
        return view('masters.employees.employees', $attr);
    }
    public function addEmployee(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required|unique:App\Models\UserAuth,username|alpha:ascii|lowercase',
                'nik' => 'required|numeric|unique:App\Models\UserDetail,nik',
                'fullname' => 'required|regex:/^[a-zA-Z\s]+$/',
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
            'role' => $request->role,
        ];
        $userdetail = [
            'nik' => $validated['nik'],
            'username' => $validated['username'],
            'fullname' => $validated['fullname'],
            'position_id' => intval($request->position),
            'created_by' => Auth::user()->username
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
            ],
            [
                'fullname.required' => 'Nama lengkap belum diisi',
                'fullname.regex' => 'Nama lengkap hanya boleh berisi huruf a-z. Anda membuat ' . "'$request->fullname'",
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
                'position_id' => $request->position,
                'updated_by' => Auth::user()->username

            ];
        } else {
            $userauth = [
                'role' => $request->role
            ];
            UserAuth::where('username', $username)->update($userauth);
            $userdetail = [
                'fullname' => $validated['fullname'],
                'position_id' => $request->position,
                'updated_by' => Auth::user()->username
            ];
        }
        UserDetail::where('username', $username)->update($userdetail);
        Alert::success('Sukses', 'Data karyawan berhasil diubah');
        return redirect()->route('employees');
    }
    public function delEmployee($username)
    {
        UserAuth::where('username', $username)->delete();
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
    public function positions()
    {
        $attr = [
            'title' => 'Data Jabatan',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'positions' => Positions::orderBy('name')->get('name'),
        ];
        confirmDelete('Hapus Jabatan', 'Apakah Anda yakin ingin menghapus jabatan ini?');
        return view('masters.positions.position', $attr);
    }
    public function addPosition(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'positionName' => 'required|regex:/^[a-zA-Z\s]+$/',
            ],
            [
                'positionName.required' => 'Nama jabatan belum diisi',
                'positionName.regex' => 'Nama jabatan hanya boleh berisi huruf a-z. Anda membuat ' . "'$request->positionName'",
            ],
        );
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('positions');
        }
        $validated = $validator->validated();
        Positions::create([
            'name' => $validated['positionName'],
            'created_by' => Auth::user()->username,
        ]);
        Alert::toast('Data jabatan berhasil ditambahkan', 'success');
        return redirect()->route('positions');
    }
    public function deletePosition($name)
    {
        try {
            Positions::where('name', $name)->delete();
            Alert::toast('Data jabatan berhasil dihapus', 'success');
        } catch (QueryException $e) {
            Alert::error('Gagal', 'Data jabatan tidak dapat dihapus karena masih digunakan oleh karyawan');
        }
        return redirect()->route('positions');
    }
    public function complaintCategories()
    {
        $attr = [
            'title' => 'Kategori Pengaduan',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'categories' => ComplaintCategories::orderBy('name')->get(),
            'categoryTypes' => ['Perangkat Keras', 'Perangkat Lunak'],
        ];
        confirmDelete('Hapus Kategori', 'Apakah Anda yakin ingin menghapus kategori ini?');
        return view('masters.complaint-categories.category', $attr);
    }
    public function addCategory(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'categoryName' => 'required|regex:/^[a-zA-Z\s]+$/',
            ],
            [
                'categoryName.required' => 'Nama kategori belum diisi',
                'categoryName.regex' => 'Nama kategori hanya boleh berisi huruf a-z. Anda membuat ' . "'$request->categoryName'",
            ],
        );
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('complaint-categories');
        }
        $validated = $validator->validated();
        ComplaintCategories::create([
            'name' => $validated['categoryName'],
            'type' => $request->categoryType,
            'created_by' => Auth::user()->username,
        ]);
        Alert::toast('Kategori pengaduan berhasil ditambahkan', 'success');
        return redirect()->route('complaint-categories');
    }
    public function deleteCategory($name)
    {
        try {
            ComplaintCategories::where('name', $name)->delete();
            Alert::toast('Kategori pengaduan berhasil dihapus', 'success');
        } catch (QueryException $e) {
            Alert::error('Gagal', 'Kategori pengaduan tidak dapat dihapus karena masih digunakan oleh pengaduan');
        }
        return redirect()->route('complaint-categories');
    }
}
