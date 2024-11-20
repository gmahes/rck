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
                                                {{-- <select class="form-select form-select-sm filter-omzet"
                                                    aria-label=".form-select-sm example" name="driver" required>
                                                    <option value="null" selected>Pilih Supir</option>
                                                    <option value="all">Semua Supir</option>
                                                    @foreach ($drivers as $driver)
                                                    <option value="{{ $driver->id }}">{{ $driver->fullname }}
                                                    </option>
                                                    @endforeach
                                                </select> --}}
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
                                                <select class="form-select add-omzet"
                                                    aria-label=".form-select-sm example" name="driver_id" required>
                                                    <option value="null" selected>Pilih Supir</option>
                                                    @foreach ($drivers as $driver)
                                                    <option value="{{ $driver->id }}">{{ $driver->fullname }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-3">
                                                <p class="card-text fs-6">Tanggal</p>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" class="form-control form-control-sm" name="date"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-3">
                                                <p class="card-text fs-6">Omzet</p>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control form-control-sm" name="omzet"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-auto d-flex">
                                                <button type="submit" class="btn btn-sm btn-primary">Tambah
                                                    Data</button>
                                                {{-- <button type="button" class="ms-1 btn btn-sm btn-primary">Unduh
                                                    Data</button> --}}
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