<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use DOMDocument;
use App\Models\Complaint;
use App\Models\ComplaintCategories;
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
            'troubles' => Auth::user()->role != 'user' ? Complaint::all()->sortBy('created_at')->where('status', 'Added') : (Auth::user()->role == 'user' && Auth::user()->userDetail->position->name == "Teknisi IT" ? Complaint::where('technician_id', Auth::user()->userDetail->nik)->whereIn('status', ['Added', 'On Process'])->get()->sortBy('created_at') : Complaint::where('nik', Auth::user()->userDetail->nik)->whereIn('status', ['Added', 'On Process'])->get()->sortBy('created_at')),
            'hardware' => ComplaintCategories::where('type', 'Perangkat Keras')->get(),
            'software' => ComplaintCategories::where('type', 'Perangkat Lunak')->get(),
            'technicians' => UserDetail::whereHas('position', function ($query) {
                $query->where('name', 'Teknisi IT');
            })->orderBy('fullname')->get(),
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
            'trouble' => 'required',
            'photo' => 'mimes:jpeg,jpg,png|max:2048',
        ], [
            'user.required' => 'Nama Karyawan wajib diisi',
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
            'category_id' => intval(request()->category),
            'trouble' => $validated['trouble'],
            'status' => 'Added',
            'photo' => request()->hasFile('photo') ? request()->file('photo')->storeAs('complaint', Str::uuid()->toString() . '.' . request()->file('photo')->getClientOriginalExtension(), 'public') : null,
            'created_by' => Auth::user()->username,
        ];
        complaint::create($complaint);
        Alert::toast('Pengaduan berhasil ditambahkan', 'success');
        return redirect()->route('complaint');
    }
    public function confirmComplaint()
    {
        complaint::where('troubleID', request()->troubleID)->update(['status' => 'On Process', 'technician_id' => request()->technician]);
        Alert::toast('Pengaduan diproses', 'success');
        return redirect()->route('complaint');
    }
    public function deleteComplaint()
    {
        complaint::where('troubleID', request()->troubleID)->delete();
        Alert::toast('Pengaduan berhasil dihapus', 'success');
        return redirect()->route('complaint');
    }
    public function editComplaint()
    {
        // dd(request()->all());
        $validator = Validator::make(request()->all(), [
            'trouble' => 'required',
            'photo' => 'mimes:jpeg,jpg,png|max:2048',
        ], [
            'trouble.required' => 'Masalah wajib diisi',
            'photo.mimes' => 'File harus berupa gambar (jpeg, jpg, png)',
        ]);
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('complaint');
        }
        $validated = $validator->validated();
        $complaintToUpdate = complaint::where('troubleID', request()->troubleID)->first();
        $complaint = [
            'category_id' => intval(request()->category),
            'trouble' => $validated['trouble'],
        ];
        if (request()->has('technician')) {
            $complaint['technician_id'] = request()->technician;
        }
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
    public function confirmedComplaint()
    {
        $attr = [
            'title' => 'Pengaduan Diproses',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'confirmedTroubles' => Complaint::where('status', 'On Process')->get()->sortBy('created_at'),
            'hardware' => ComplaintCategories::where('type', 'Perangkat Keras')->get(),
            'software' => ComplaintCategories::where('type', 'Perangkat Lunak')->get(),
            'technicians' => UserDetail::whereHas('position', function ($query) {
                $query->where('name', 'Teknisi IT');
            })->orderBy('fullname')->get(),
        ];
        return view('helpdesk.complaints.confirmedComplaint', $attr);
    }
    public function complaintAction()
    {
        $validator = Validator::make(request()->all(), [
            'action' => 'required',
        ], [
            'action.required' => 'Tindakan wajib diisi',
        ]);
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('confirmed-complaint');
        }
        $validated = $validator->validated();
        complaint::where('troubleID', request()->troubleID)->update([
            'action' => $validated['action'],
            'status' => 'Finished',
        ]);
        Alert::toast('Pengaduan telah diselesaikan', 'success');
        return redirect()->route('confirmed-complaint');
    }
    public function complaintHistory()
    {
        $attr = [
            'title' => 'Riwayat Pengaduan',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'troubleHistory' => Complaint::where('status', 'Finished')->get()->sortBy('created_at'),
        ];
        return view('helpdesk.complaints.complaintHistory', $attr);
    }
}
