<?php

namespace App\Http\Controllers;

use App\Models\Drivers;
use App\Models\Omzet;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
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
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
            'bigvehicledrivers' => Drivers::all()->where('vehicle_type', 'Kendaraan Besar')->sortBy('fullname'),
            'smallvehicledrivers' => Drivers::all()->where('vehicle_type', 'Kendaraan Kecil')->sortBy('fullname'),
        ];
        return view('operasional.omzet.omzet', $attr);
    }
    public function addOmzet(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'driver_id' => 'required',
                'date' => 'required|date',
                'omzet' => 'required|regex:/^[0-9.;]+$/',
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
        if ($request->driver_id == 'null') {
            Alert::error('Gagal', 'Driver belum dipilih');
            return redirect()->route('omzet');
        }
        $validated = $validator->validated();
        // Process the 'omzet' input
        $omzetParts = explode(';', $validated['omzet']);
        // Remove dots from each value in the array
        $omzetParts = array_map(function ($value) {
            return str_replace('.', '', $value);
        }, $omzetParts);
        $omzetSum = array_sum(array_map('intval', $omzetParts));
        // Save to Omzet model
        $omzet = new Omzet();
        $omzet->driver_id = $validated['driver_id'];
        $omzet->date = $validated['date'];
        $omzet->omzet = $omzetSum;
        $omzet->created_by = Auth::user()->username;
        $omzet->save();
        Alert::success('Berhasil', 'Omzet ' . Drivers::find($validated['driver_id'])->fullname . ' dengan nominal Rp ' . number_format($omzetSum, 0, ',', '.') . ' berhasil ditambahkan');
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
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->route('omzet');
        }
        if ($request->driver == 'null') {
            Alert::error('Gagal', 'Driver belum dipilih');
            return redirect()->route('omzet');
        }
        $validated = $validator->validated();
        session([
            'driver' => $validated['driver'],
            'start_date' => strtotime($validated['start_date']),
            'end_date' => strtotime($validated['end_date']),
        ]);
        if ($validated['start_date'] > $validated['end_date']) {
            Alert::error('Gagal', 'Tanggal awal tidak boleh lebih besar dari tanggal akhir');
            return redirect()->route('omzet');
        }
        if ($validated['driver'] == 'allBig') {
            $omzet = Omzet::whereBetween('date', [$validated['start_date'], $validated['end_date']])
                ->get()
                ->groupBy('driver_id');
            $totalOmzetPerDriver = $omzet->map(function ($group) {
                return $group->sum('omzet');
            });
            $totalOmzet = $totalOmzetPerDriver->sum();
            $attr = [
                'title' => 'Omzet',
                'fullname' => Auth::user()->userDetail->fullname,
                'position' => Auth::user()->userDetail->position,
                'drivers' => Drivers::all()->where('vehicle_type', 'Kendaraan Besar')->where('status', 'Aktif')->sortBy('fullname'),
                'supir' => null,
                'omzet' => $omzet,
                'totalOmzet' => number_format($totalOmzet, 0, ',', '.'),
                'totalOmzetPerDriver' => $totalOmzetPerDriver,
                'bigvehicledrivers' => Drivers::all()->where('vehicle_type', 'Kendaraan Besar')->where('status', 'Aktif')->sortBy('fullname'),
                'smallvehicledrivers' => Drivers::all()->where('vehicle_type', 'Kendaraan Kecil')->sortBy('fullname'),
                'filter' => [
                    'driver' => $validated['driver'],
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'],
                ],
                'start_date' => strtotime($validated['start_date']),
                'end_date' => strtotime($validated['end_date']),
            ];
            return view('operasional.omzet.filterOmzet', $attr);
        } elseif ($validated['driver'] == 'allSmall') {
            $omzet = Omzet::whereBetween('date', [$validated['start_date'], $validated['end_date']])
                ->get()
                ->groupBy('driver_id');
            $totalOmzetPerDriver = $omzet->map(function ($group) {
                return $group->sum('omzet');
            });
            $totalOmzet = $totalOmzetPerDriver->sum();
            $attr = [
                'title' => 'Omzet',
                'fullname' => Auth::user()->userDetail->fullname,
                'position' => Auth::user()->userDetail->position,
                'drivers' => Drivers::all()->where('vehicle_type', 'Kendaraan Kecil')->sortBy('fullname'),
                'supir' => null,
                'omzet' => $omzet,
                'totalOmzet' => number_format($totalOmzet, 0, ',', '.'),
                'totalOmzetPerDriver' => $totalOmzetPerDriver,
                'bigvehicledrivers' => Drivers::all()->where('vehicle_type', 'Kendaraan Besar')->sortBy('fullname'),
                'smallvehicledrivers' => Drivers::all()->where('vehicle_type', 'Kendaraan Kecil')->sortBy('fullname'),
                'filter' => [
                    'driver' => $validated['driver'],
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'],
                ],
                'start_date' => strtotime($validated['start_date']),
                'end_date' => strtotime($validated['end_date']),
            ];
            return view('operasional.omzet.filterOmzet', $attr);
        } else {
            $driver = Drivers::where('id', $validated['driver'])->get();
            $omzet = Omzet::where('driver_id', $validated['driver'])
                ->whereBetween('date', [$validated['start_date'], $validated['end_date']])
                ->get();
            $totalOmzet = $omzet->sum('omzet');
            $attr = [
                'title' => 'Omzet',
                'fullname' => Auth::user()->userDetail->fullname,
                'position' => Auth::user()->userDetail->position,
                'drivers' => Drivers::all()->where('vehicle_type', 'Kendaraan Kecil')->sortBy('fullname'),
                'supir' => $driver,
                'omzet' => $omzet,
                'totalOmzet' => number_format($totalOmzet, 0, ',', '.'),
                'bigvehicledrivers' => Drivers::all()->where('vehicle_type', 'Kendaraan Besar')->sortBy('fullname'),
                'smallvehicledrivers' => Drivers::all()->where('vehicle_type', 'Kendaraan Kecil')->sortBy('fullname'),
                'filter' => [
                    'driver' => $validated['driver'],
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'],
                ],
                'start_date' => strtotime($validated['start_date']),
                'end_date' => strtotime($validated['end_date']),
            ];
            return view('operasional.omzet.filterOmzet', $attr);
        }
    }
    public function printOmzet($driver, $start_date, $end_date)
    {
        if ($driver == 'allBig') {
            $omzet = Omzet::whereBetween('date', [$start_date, $end_date])
                ->whereHas('drivers', function ($query) {
                    $query->where('vehicle_type', 'Kendaraan Besar')->where('status', 'Aktif');
                })
                ->get()
                ->groupBy('driver_id');
            $totalOmzetPerDriver = $omzet->map(function ($group) {
                return $group->sum('omzet');
            });
            $totalOmzet = $totalOmzetPerDriver->sum();
            $attr = [
                'title' => 'Omzet',
                'fullname' => Auth::user()->userDetail->fullname,
                'position' => Auth::user()->userDetail->position,
                'drivers' => Drivers::all()->where('vehicle_type', 'Kendaraan Besar')->where('status', 'Aktif')->sortBy('fullname'),
                'supir' => null,
                'omzet' => $omzet,
                'totalOmzet' => number_format($totalOmzet, 0, ',', '.'),
                'totalOmzetPerDriver' => $totalOmzetPerDriver,
                'filter' => [
                    'driver' => $driver,
                    'start_date' => strtotime($start_date),
                    'end_date' => strtotime($end_date),
                ],
            ];
            return PDF::loadView('operasional.omzet.printOmzet', $attr)->setPaper('legal')->setOptions(['disable-smart-shrinking' => true])->inline('Omzet.pdf');
        } elseif ($driver == 'allSmall') {
            $omzet = Omzet::whereBetween('date', [$start_date, $end_date])
                ->whereHas('drivers', function ($query) {
                    $query->where('vehicle_type', 'Kendaraan Kecil');
                })
                ->get()
                ->groupBy('driver_id');
            $totalOmzetPerDriver = $omzet->map(function ($group) {
                return $group->sum('omzet');
            });
            $totalOmzet = $totalOmzetPerDriver->sum();
            $attr = [
                'title' => 'Omzet',
                'fullname' => Auth::user()->userDetail->fullname,
                'position' => Auth::user()->userDetail->position,
                'drivers' => Drivers::all()->where('vehicle_type', 'Kendaraan Kecil')->sortBy('fullname'),
                'supir' => null,
                'omzet' => $omzet,
                'totalOmzet' => number_format($totalOmzet, 0, ',', '.'),
                'totalOmzetPerDriver' => $totalOmzetPerDriver,
                'filter' => [
                    'driver' => $driver,
                    'start_date' => strtotime($start_date),
                    'end_date' => strtotime($end_date),
                ],
            ];
            return PDF::loadView('operasional.omzet.printOmzet', $attr)->setPaper('legal')->setOptions(['disable-smart-shrinking' => true])->inline('Omzet.pdf');
        } else {
            $driver = Drivers::where('id', $driver)->get();
            $omzet = Omzet::where('driver_id', $driver->first()->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->get();
            $totalOmzet = $omzet->sum('omzet');
            $attr = [
                'title' => 'Omzet',
                'fullname' => Auth::user()->userDetail->fullname,
                'position' => Auth::user()->userDetail->position,
                'drivers' => Drivers::all()->where('vehicle_type', 'Kendaraan Kecil')->sortBy('fullname'),
                'supir' => $driver,
                'omzet' => $omzet,
                'totalOmzet' => number_format($totalOmzet, 0, ',', '.'),
                'filter' => [
                    'driver' => $driver,
                    'start_date' => strtotime($start_date),
                    'end_date' => strtotime($end_date),
                ],
            ];
            return PDF::loadView('operasional.omzet.printOmzet', $attr)->setPaper('legal')->setOptions(['disable-smart-shrinking' => true])->inline('Omzet.pdf');
        }
    }
}
