<?php

namespace App\Http\Controllers;

use App\Models\Drivers;
use App\Models\UserAuth;
use App\Models\UserDetail;
use App\Models\Customers;
use App\Models\Suppliers;
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
            'division_list' => ['Operasional', 'Non Operasional'],
            'role_list' => ['administrator', 'user'],
            'employees' => UserDetail::join('user_auth', 'user_detail.username', '=', 'user_auth.username')
                ->where('user_auth.role', '!=', 'superadmin')
                ->orderBy('user_detail.fullname')
                ->get(['user_detail.*'])
        ];
        return view('masters.employees.employees', $attr);
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
            'role' => $request->role,
        ];
        $userdetail = [
            'nik' => $validated['nik'],
            'username' => $validated['username'],
            'fullname' => $validated['fullname'],
            'position' => $validated['position'],
            'division' => $validated['division'],
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
                'division' => $validated['division'],
                'updated_by' => Auth::user()->username

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
    public function drivers()
    {
        $attr = [
            'title' => 'Data Supir',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'vehicle_type' => ['Kendaraan Kecil', 'Kendaraan Besar'],
            'drivers' => Drivers::all()->sortBy('fullname')
        ];
        return view('masters.drivers.drivers', $attr);
    }
    public function addDriver(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'fullname' => 'required|regex:/^[a-zA-Z\s]+$/',
                'vehicle_type' => 'required',
                'vehicle_number' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            ],
            [
                'fullname.required' => 'Nama lengkap belum diisi',
                'fullname.regex' => 'Nama lengkap hanya boleh berisi huruf a-z. Anda membuat ' . "'$request->fullname'",
                'vehicle_type.required' => 'Tipe kendaraan belum dipilih',
                'vehicle_number.required' => 'Nomor kendaraan belum diisi',
                'vehicle_number.regex' => 'Nomor kendaraan hanya boleh berisi huruf a-z. Anda membuat ' . "'$request->vehicle_number'",
            ],
        );
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('drivers');
        }
        $validated = $validator->validated();
        $driver = [
            'fullname' => $validated['fullname'],
            'vehicle_type' => $validated['vehicle_type'],
            'vehicle_number' => $validated['vehicle_number'],
            'created_by' => Auth::user()->username
        ];
        Drivers::create($driver);
        Alert::success('Sukses', 'Data supir berhasil ditambahkan');
        return redirect()->route('drivers');
    }
    public function editDriver(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'fullname' => 'required|regex:/^[a-zA-Z\s]+$/',
                'vehicle_type' => 'required',
                'vehicle_number' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            ],
            [
                'fullname.required' => 'Nama lengkap belum diisi',
                'fullname.regex' => 'Nama lengkap hanya boleh berisi huruf a-z. Anda membuat ' . "'$request->fullname'",
                'vehicle_type.required' => 'Tipe kendaraan belum dipilih',
                'vehicle_number.required' => 'Nomor kendaraan belum diisi',
                'vehicle_number.regex' => 'Nomor kendaraan hanya boleh berisi huruf a-z. Anda membuat ' . "'$request->vehicle_number'",
            ],
        );
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('drivers');
        }
        $validated = $validator->validated();
        $driver = [
            'fullname' => $validated['fullname'],
            'status' => $request->status,
            'vehicle_type' => $validated['vehicle_type'],
            'vehicle_number' => $validated['vehicle_number'],
            'updated_by' => Auth::user()->username
        ];
        Drivers::where('id', $id)->update($driver);
        Alert::success('Sukses', 'Data supir berhasil diubah');
        return redirect()->route('drivers');
    }
    public function delDriver($id)
    {
        Drivers::where('id', $id)->delete();
        Alert::success('Sukses', 'Data supir berhasil dihapus');
        return redirect()->route('drivers');
    }
    public function customers()
    {
        $attr = [
            'title' => 'Data Pelanggan',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'customers' => Customers::all()->sortBy('name')
        ];
        // dd($attr['customers']);
        return view('masters.customers.customers', $attr);
    }
    public function addCustomer(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'idNumber' => 'required',
                'idNumberType' => 'required',
                'address' => 'required',
            ],
            [
                'name.required' => 'Nama pelanggan belum diisi',
                'idNumber.required' => 'ID pelanggan belum diisi',
                'idNumberType.required' => 'Tipe pelanggan belum dipilih',
                'address.required' => 'Alamat pelanggan belum diisi',
            ],
        );
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('customers');
        }
        $validated = $validator->validated();
        $customer = [
            'id' => $validated['idNumber'],
            'name' => $validated['name'],
            'type' => $validated['idNumberType'],
            'address' => $validated['address'],
            'created_by' => Auth::user()->username
        ];
        Customers::create($customer);
        Alert::success('Sukses', 'Data pelanggan berhasil ditambahkan');
        return redirect()->route('customers');
    }
    public function editCustomer(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'address' => 'required',
            ],
            [
                'name.required' => 'Nama pelanggan belum diisi',
                'address.required' => 'Alamat pelanggan belum diisi',
            ],
        );
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('customers');
        }
        $validated = $validator->validated();
        $customer = [
            'name' => $validated['name'],
            'address' => $validated['address'],
            'updated_by' => Auth::user()->username
        ];
        Customers::where('id', $id)->update($customer);
        Alert::success('Sukses', 'Data pelanggan berhasil diubah');
        return redirect()->route('customers');
    }
    public function delCustomer($id)
    {
        Customers::where('id', $id)->delete();
        Alert::success('Sukses', 'Data pelanggan berhasil dihapus');
        return redirect()->route('customers');
    }
    public function suppliers()
    {
        $attr = [
            'title' => 'Data Supplier',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'suppliers' => Suppliers::all()->sortBy('name'),
        ];
        $document = [
            'TaxInvoice' => 'Faktur Pajak',
            'PaymentProof' => 'Bukti Pembayaran',
        ];
        $facility = [
            'N/A' => 'Tanpa Fasilitas',
            'TaxExAr22' => 'SKB PPh Pasal 22',
            'TaxExAr23' => 'SKB PPh Pasal 23',
            'PP23' => 'SK PP 23/2018'
        ];
        $attr['document'] = $document;
        $attr['facility'] = $facility;
        foreach ($attr['suppliers'] as $supplier) {
            $supplier->document = $document[$supplier->document];
            $supplier->facility = $facility[$supplier->facility];
        }
        // dd($attr['suppliers']);
        return view('masters.suppliers.suppliers', $attr);
    }
    public function addSupplier(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'name' => 'required',
                'code' => 'required',
                'percentage' => 'required|numeric',
                'document' => 'required',
                'facility' => 'required',
            ],
            [
                'id.required' => 'ID supplier belum diisi',
                'name.required' => 'Nama supplier belum diisi',
                'code.required' => 'Kode supplier belum diisi',
                'percentage.required' => 'Persentase supplier belum diisi',
                'percentage.numeric' => 'Persentase supplier hanya boleh berisi angka. Anda membuat ' . "'$request->percentage'",
                'document.required' => 'Dokumen supplier belum dipilih',
                'facility.required' => 'Fasilitas supplier belum dipilih',
            ],
        );
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('suppliers');
        }
        $validated = $validator->validated();
        $supplier = [
            'id' => $validated['id'],
            'name' => $validated['name'],
            'alias' => request()->alias == null ? '' : request()->alias,
            'code' => $validated['code'],
            'percentage' => $validated['percentage'],
            'document' => $validated['document'],
            'facility' => $validated['facility'],
            'created_by' => Auth::user()->username
        ];
        Suppliers::create($supplier);
        Alert::success('Sukses', 'Data supplier berhasil ditambahkan');
        return redirect()->route('suppliers');
    }
    public function editSupplier(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'code' => 'required',
                'percentage' => 'required|numeric',
                'document' => 'required',
                'facility' => 'required',
            ],
            [
                'name.required' => 'Nama supplier belum diisi',
                'code.required' => 'Kode supplier belum diisi',
                'percentage.required' => 'Persentase supplier belum diisi',
                'percentage.numeric' => 'Persentase supplier hanya boleh berisi angka. Anda membuat ' . "'$request->percentage'",
                'document.required' => 'Dokumen supplier belum dipilih',
                'facility.required' => 'Fasilitas supplier belum dipilih',
            ],
        );
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('suppliers');
        }
        $validated = $validator->validated();
        $supplier = [
            'name' => $validated['name'],
            'alias' => request()->alias == null ? '' : request()->alias,
            'code' => $validated['code'],
            'percentage' => $validated['percentage'],
            'document' => $validated['document'],
            'facility' => $validated['facility'],
            'updated_by' => Auth::user()->username
        ];
        Suppliers::where('id', $id)->update($supplier);
        Alert::success('Sukses', 'Data supplier berhasil diubah');
        return redirect()->route('suppliers');
    }
    public function delSupplier($id)
    {
        try {
            Suppliers::where('id', $id)->delete();
            Alert::success('Sukses', 'Data supplier berhasil dihapus');
        } catch (QueryException $e) {
            Alert::error('Gagal', 'Data supplier tidak bisa dihapus karena masih terdapat data yang terkait');
            return redirect()->route('suppliers');
        }
        return redirect()->route('suppliers');
    }
}
