<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ITDocs;
use DOMDocument;
use App\Models\UserDetail;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleXMLElement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class NonOperasionalController extends Controller
{
    public function itdocs()
    {
        $attr = [
            'title' => 'Dokumentasi IT',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'employees' => UserDetail::whereHas('userAuth', function ($query) {
                $query->where('role', '!=', 'superadmin');
            })->orderBy('fullname')->get(),
            'troubles' => ITDocs::all()->sortBy('created_at'),
        ];
        $dateCode = date('ymd');
        $prefix = 'IT-RCK/' . $dateCode . '/';

        $lastKode = ITDocs::where('troubleID', 'like', $prefix . '%')
            ->orderBy('troubleID', 'desc')
            ->value('troubleID');

        if ($lastKode) {
            $lastNumber = (int) substr($lastKode, -3);
            $urut = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $urut = '001';
        }
        $troubleID = $prefix . $urut;
        $attr['troubleID'] = $troubleID;
        return view('non-operasional.itdocs.itdocs', $attr);
    }
    public function saveITDocs()
    {
        $validator = Validator::make(request()->all(), [
            'user' => 'required',
            'devices' => 'required',
            'trouble' => 'required',
            'status' => 'required',
            'photo' => 'mimes:jpeg,jpg,png|max:2048',
        ], [
            'user.required' => 'Nama Karyawan wajib diisi',
            'devices.required' => 'Sistem wajib diisi',
            'trouble.required' => 'Masalah wajib diisi',
            'status.required' => 'Status wajib diisi',
            'photo.mimes' => 'File harus berupa gambar (jpeg, jpg, png)',
        ]);
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('itdocs');
        }
        $validated = $validator->validated();
        $itdocs = [
            'nik' => $validated['user'],
            'devices' => $validated['devices'],
            'trouble' => $validated['trouble'],
            'status' => $validated['status'],
            'photo' => request()->hasFile('photo') ? request()->file('photo')->storeAs('itdocs', Str::uuid()->toString() . '.' . request()->file('photo')->getClientOriginalExtension(), 'public') : null,
            'action' => request()->has('action') ? request()->action : null,
            'created_by' => Auth::user()->username,
        ];
        // dd($itdocs);
        ITDocs::create($itdocs);
        Alert::toast('Data berhasil disimpan', 'success');
        return redirect()->route('itdocs');
    }
    public function deleteITDocs()
    {
        ITDocs::where('troubleID', request()->troubleID)->delete();
        Alert::toast('Data berhasil dihapus', 'success');
        return redirect()->route('itdocs');
    }
    public function editITDocs()
    {
        $validator = Validator::make(request()->all(), [
            'user' => 'required',
            'devices' => 'required',
            'trouble' => 'required',
            'status' => 'required',
            'photo' => 'mimes:jpeg,jpg,png|max:2048',
        ], [
            'user.required' => 'Nama Karyawan wajib diisi',
            'devices.required' => 'Sistem wajib diisi',
            'trouble.required' => 'Masalah wajib diisi',
            'status.required' => 'Status wajib diisi',
            'photo.mimes' => 'File harus berupa gambar (jpeg, jpg, png)',
        ]);
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('itdocs');
        }
        $validated = $validator->validated();
        $itdocsToUpdate = ITDocs::where('troubleID', request()->troubleID)->first();
        $itdocs = [
            'nik' => $validated['user'],
            'devices' => $validated['devices'],
            'trouble' => $validated['trouble'],
            'status' => $validated['status'],
            'action' => request()->has('action') ? request()->action : null,
        ];
        if (request()->hasFile('photo')) {
            // Jika ada foto baru diupload:
            // Hapus foto lama jika ada dan file-nya benar-benar ada di storage
            if ($itdocsToUpdate->photo && Storage::disk('public')->exists($itdocsToUpdate->photo)) {
                Storage::disk('public')->delete($itdocsToUpdate->photo);
            }
            // Simpan foto baru
            $photoPath = request()->file('photo')->storeAs('itdocs', Str::uuid()->toString() . '.' . request()->file('photo')->getClientOriginalExtension(), 'public');
            $itdocs['photo'] = $photoPath;
        } else {
            // Jika tidak ada foto baru diupload:
            // Pertahankan foto yang sudah ada di database dengan mengambil dari model yang diambil
            $itdocs['photo'] = $itdocsToUpdate->photo;
        }
        ITDocs::where('troubleID', request()->troubleID)->update($itdocs);
        Alert::toast('Data berhasil diubah', 'success');
        return redirect()->route('itdocs');
    }
}
