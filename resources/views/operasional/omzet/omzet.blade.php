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
                            <p class="card-text fw-bold text-dark fs-5">Target Omzet</p>
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
                                            <div class="col-md-6">
                                                <select name="driver" id="" class="selectpicker" data-width="100%"
                                                    data-size="5" data-live-search="true" required>
                                                    <option value="">-- Pilih Supir --</option>
                                                    <optgroup label="Kendaraan Besar">
                                                        <option value="allBig">Semua Supir</option>
                                                        @foreach ($bigvehicledrivers as $driver)
                                                        <option value="{{ $driver->id }}">{{ $driver->fullname }}
                                                        </option>
                                                        @endforeach
                                                    </optgroup>
                                                    <optgroup label="Kendaraan Kecil">
                                                        <option value="allSmall">Semua Supir</option>
                                                        @foreach ($smallvehicledrivers as $driver)
                                                        <option value="{{ $driver->id }}">{{ $driver->fullname }}
                                                        </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-3">
                                                <p class="card-text fs-6">Tanggal Awal</p>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="date" class="form-control form-control-sm"
                                                    name="start_date" required>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-3">
                                                <p class="card-text fs-6">Tanggal Akhir</p>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="date" class="form-control form-control-sm" name="end_date"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-auto d-flex">
                                                <button type="submit" class="btn btn-sm btn-primary">Cari Data</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col">
                                    <p class="card-text fw-bold fs-6 mt-2">Tambah Data</p>
                                    <form action="{{ route('add-omzet') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3 mt-1">
                                                <p class="card-text">Supir</p>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="driver_id" class="selectpicker" data-live-search="true"
                                                    data-size="4" data-width="100%" required>
                                                    <option value="">-- Pilih Supir --</option>
                                                    <optgroup label="Kendaraan Besar">
                                                        @foreach ($bigvehicledrivers as $driver)
                                                        <option value="{{ $driver->id }}">{{ $driver->fullname }}
                                                        </option>
                                                        @endforeach
                                                    </optgroup>
                                                    <optgroup label="Kendaraan Kecil">
                                                        @foreach ($smallvehicledrivers as $driver)
                                                        <option value="{{ $driver->id }}">{{ $driver->fullname }}
                                                        </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-3">
                                                <p class="card-text fs-6">Tanggal</p>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="date" class="form-control form-control-sm" name="date"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-3">
                                                <p class="card-text fs-6">Omzet</p>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" id="omzet" class="form-control form-control-sm"
                                                    name="omzet" autocomplete="off" placeholder="Pisahkan dengan ';'"
                                                    required>
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
        </div>
    </section>
</main>
@endsection