@extends('layouts.index')
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Selamat Datang di RCK Office!</h1>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <p class="card-text fw-bold text-dark fs-5">Rekap Tabungan Ban Supir</p>
                            </div>
                        </div>
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
                                <form action="" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p class="card-text">Supir</p>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-select form-select-sm" name="driver_id" required>
                                                <option value="">Pilih Supir</option>
                                                @foreach ($drivers as $driver)
                                                <option value="{{ $driver->id }}">{{ $driver->fullname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-3">
                                            <p class="card-text fs-6">Tanggal Awal</p>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="date" class="form-control form-control-sm" name="start_date"
                                                required>
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
                            </div>
                            <div class="col">
                                <p class="card-text fw-bold mt-2">Tambah Data</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
@endsection