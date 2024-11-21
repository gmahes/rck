@extends('layouts.index')
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Selamat Datang di RCK Office!</h1>
    </div>
    <section class="section">
        <div class="col">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header">
                            <p class="card-text fw-bold text-primary-emphasis fs-5">Target Omzet</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <p class="card-text fw-bold mt-2">Filter Data</p>
                                    <form action="{{ route('filter-omzet') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p class="card-text">Supir</p>
                                            </div>
                                            <div class="col-md-4">
                                                @livewire('driver-list')
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-3">
                                                <p class="card-text fs-6">Tanggal Awal</p>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" class="form-control form-control-sm"
                                                    name="start_date" required>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-3">
                                                <p class="card-text fs-6">Tanggal Akhir</p>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" class="form-control form-control-sm" name="end_date"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-auto d-flex">
                                                <button type="submit" class="btn btn-sm btn-primary">Cari Data</button>
                                                <a href="{{ route('print-omzet', [$filter['vehicleType'], $filter['driver'], $filter['start_date'], $filter['end_date']]) }}"
                                                    class="btn btn-sm btn-success ms-1" target="_blank">Unduh Data</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col">
                                    <p class="card-text fw-bold fs-6 mt-2">Tambah Data</p>
                                    <form action="{{ route('add-omzet') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p class="card-text">Supir</p>
                                            </div>
                                            <div class="col-md-4">
                                                {{-- <select class="form-select form-select-sm"
                                                    aria-label=".form-select-sm example" name="driver_id">
                                                    <option value="null" selected>Pilih Supir</option>
                                                    @foreach ($drivers as $driver)
                                                    <option value="{{ $driver->id }}">{{ $driver->fullname }}
                                                    </option>
                                                    @endforeach
                                                </select> --}}
                                                @livewire('driver-list-add')
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-3">
                                                <p class="card-text fs-6">Tanggal</p>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" class="form-control form-control-sm" name="date">
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-3">
                                                <p class="card-text fs-6">Omzet</p>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control form-control-sm" name="omzet">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-auto d-flex">
                                                <button type="submit" class="btn btn-sm btn-primary">Tambah
                                                    Data</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card mt-1 shadow">
                        <div class="card-body">
                            <p class="text-dark h6 fw-bold mt-3">Periode : {{ date('d M Y', $start_date)
                                . ' s/d '.
                                date('d M Y', $end_date) }}
                            </p>
                            @if ($supir == null)
                            <table class="table mt-3" data-toggle="table" data-pagination="true">
                                <thead class="table-dark">
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Nomor Kendaraan</th>
                                        <th>Jenis Kendaraan</th>
                                        <th>Omzet</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($drivers as $driver)
                                    <tr class="text-center">
                                        <td class="fw-bold">{{ $loop->iteration }}</td>
                                        <td>{{ $driver->fullname }}</td>
                                        <td>{{ $driver->vehicle_number }}</td>
                                        <td>{{ $driver->vehicle_type }}</td>
                                        <td class="fw-bold">
                                            {{ "Rp".number_format($totalOmzetPerDriver[$driver->id] ?? 0, 0, ',', '.')
                                            }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <table class="table mt-3" data-toggle="table">
                                <thead class="table-dark">
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Nomor Kendaraan</th>
                                        <th>Jenis Kendaraan</th>
                                        <th>Omzet</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td class="fw-bold">1</td>
                                        <td>{{ $supir->first()->fullname }}</td>
                                        <td>{{ $supir->first()->vehicle_number }}</td>
                                        <td>{{ $supir->first()->vehicle_type }}</td>
                                        <td class="fw-bold">{{ "Rp".$totalOmzet }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection