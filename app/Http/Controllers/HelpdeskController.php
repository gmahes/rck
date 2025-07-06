<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use DOMDocument;
use App\Models\Complaint;
use App\Models\UserDetail;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleXMLElement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class HelpdeskController extends Controller
{
    public function complaint()
    {
        $attr = [
            'title' => 'Pengaduan',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'employees' => UserDetail::whereHas('userAuth', function ($query) {
                $query->where('role', '!=', 'superadmin');
            })->orderBy('fullname')->get(),
            'troubles' => Auth::user()->role == 'administrator' || Auth::user()->role == 'superadmin' ? Complaint::all()->sortBy('created_at') : Complaint::where('nik', Auth::user()->userDetail->nik)->get()->sortBy('created_at'),
        ];
        $dateCode = date('ymd');
        $prefix = 'IT-RCK/' . $dateCode . '/';

        $lastKode = complaint::where('troubleID', 'like', $prefix . '%')
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
        return view('helpdesk.complaints.complaint', $attr);
    }
    public function saveComplaint()
    {
        $validator = Validator::make(request()->all(), [
            'user' => 'required',
            'devices' => 'required',
            'trouble' => 'required',
            'photo' => 'mimes:jpeg,jpg,png|max:2048',
        ], [
            'user.required' => 'Nama Karyawan wajib diisi',
            'devices.required' => 'Sistem wajib diisi',
            'trouble.required' => 'Masalah wajib diisi',
            'photo.mimes' => 'File harus berupa gambar (jpeg, jpg, png)',
        ]);
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('complaint');
        }
        $validated = $validator->validated();
        $complaint = [
            'nik' => $validated['user'],
            'devices' => $validated['devices'],
            'trouble' => $validated['trouble'],
            'status' => 'Added',
            'photo' => request()->hasFile('photo') ? request()->file('photo')->storeAs('complaint', Str::uuid()->toString() . '.' . request()->file('photo')->getClientOriginalExtension(), 'public') : null,
            'created_by' => Auth::user()->username,
        ];
        complaint::create($complaint);
        Alert::toast('Data berhasil disimpan', 'success');
        return redirect()->route('complaint');
    }
    public function deleteComplaint()
    {
        complaint::where('troubleID', request()->troubleID)->delete();
        Alert::toast('Data berhasil dihapus', 'success');
        return redirect()->route('complaint');
    }
    public function editComplaint()
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
            return redirect()->route('complaint');
        }
        $validated = $validator->validated();
        $complaintToUpdate = complaint::where('troubleID', request()->troubleID)->first();
        $complaint = [
            'nik' => $validated['user'],
            'devices' => $validated['devices'],
            'trouble' => $validated['trouble'],
            'status' => $validated['status'],
            'action' => request()->has('action') ? request()->action : null,
        ];
        if (request()->hasFile('photo')) {
            // Jika ada foto baru diupload:
            // Hapus foto lama jika ada dan file-nya benar-benar ada di storage
            if ($complaintToUpdate->photo && Storage::disk('public')->exists($complaintToUpdate->photo)) {
                Storage::disk('public')->delete($complaintToUpdate->photo);
            }
            // Simpan foto baru
            $photoPath = request()->file('photo')->storeAs('complaint', Str::uuid()->toString() . '.' . request()->file('photo')->getClientOriginalExtension(), 'public');
            $complaint['photo'] = $photoPath;
        } else {
            // Jika tidak ada foto baru diupload:
            // Pertahankan foto yang sudah ada di database dengan mengambil dari model yang diambil
            $complaint['photo'] = $complaintToUpdate->photo;
        }
        complaint::where('troubleID', request()->troubleID)->update($complaint);
        Alert::toast('Data berhasil diubah', 'success');
        return redirect()->route('complaint');
    }
}
