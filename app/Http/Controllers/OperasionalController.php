<?php

namespace App\Http\Controllers;

use App\Models\Drivers;
use App\Models\Omzet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class OperasionalController extends Controller
{
    public function omzet(Request $request)
    {
        $attr = [
            'title' => 'Omzet',
            'fullname' => $request->session()->get('userdetail')['fullname'],
            'position' => $request->session()->get('userdetail')['position'],
            'drivers' => Drivers::all(),
        ];
        return view('operasional.omzet', $attr);
    }
    public function addOmzet(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'driver_id' => 'required',
                'date' => 'required|date',
                'omzet' => 'required|regex:/^[0-9,]+$/',
            ],
            [
                'driver_id.required' => 'Driver belum dipilih',
                'date.required' => 'Tanggal belum diisi',
                'date.date' => 'Tanggal tidak valid',
                'omzet.required' => 'Omzet belum diisi',
                'omzet.regex' => 'Omzet hanya boleh berisi angka dan koma. Anda membuat ' . "'$request->omzet'",
            ],
        );
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('omzet');
        }
        $validated = $validator->validated();
        // Process the 'omzet' input
        $omzetParts = explode(',', $validated['omzet']);
        $omzetSum = array_sum(array_map('intval', $omzetParts));

        // Save to Omzet model
        $omzet = new Omzet();
        $omzet->driver_id = $validated['driver_id'];
        $omzet->date = $validated['date'];
        $omzet->omzet = $omzetSum;
        $omzet->created_by = Auth::user()->username;
        $omzet->save();

        Alert::success('Berhasil', 'Omzet berhasil ditambahkan');
        return redirect()->route('omzet');
    }
    public function filterOmzet(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'driver' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ],
            [
                'driver.required' => 'Driver belum dipilih',
                'start_date.required' => 'Tanggal awal belum diisi',
                'start_date.date' => 'Tanggal awal tidak valid',
                'end_date.required' => 'Tanggal akhir belum diisi',
                'end_date.date' => 'Tanggal akhir tidak valid',
            ],
        );
        // dd($request->all());
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('omzet');
        }
        $validated = $validator->validated();
        $driver = Drivers::find($validated['driver']);
        $omzet = Omzet::where('driver_id', $validated['driver'])
            ->whereBetween('date', [$validated['start_date'], $validated['end_date']])
            ->get();
        $totalOmzet = $omzet->sum('omzet');
        $attr = [
            'title' => 'Omzet',
            'fullname' => $request->session()->get('userdetail')['fullname'],
            'position' => $request->session()->get('userdetail')['position'],
            'drivers' => Drivers::all(),
            'driver' => $driver,
            'omzet' => $omzet,
            'totalOmzet' => $totalOmzet,
        ];
        // dd($attr['driver']);
        return view('operasional.filterOmzet', $attr);
    }
}
