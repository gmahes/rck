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
                        <p class="card-text fw-bold text-dark fs-5">Bukti Potong PPh</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row mt-1">
                            <p class="card-text fw-bold">Data Supplier</p>
                            <form action="{{ route('save-bupot') }}" method="POST">
                                @csrf
                                @livewire('get-supplier')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row mt-1">
                            <p class="card-text fw-bold">Filter Data Bupot</p>
                        </div>
                        <div class="row mt-1">
                            <div class="col">
                                <form action="{{ route('filter-bupot') }}" method="POST">
                                    @csrf
                                    <div class="row mt-1">
                                        <div class="col-md-4">
                                            <p class="card-text mt-1 fs-6">Opsi Filter</p>
                                        </div>
                                        <div class="col">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="filteropt"
                                                    id="createDate" value="createDate" required>
                                                <label class="form-check-label" for="createDate">Tanggal Simpan</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="filteropt"
                                                    id="docDate" value="docDate">
                                                <label class="form-check-label" for="docDate">Tanggal Dokumen</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-4">
                                            <p class="card-text fs-6">Tanggal Awal</p>
                                        </div>
                                        <div class="col">
                                            <input type="date" class="form-control form-control-sm" name="start_date"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-4">
                                            <p class="card-text fs-6">Tanggal Akhir</p>
                                        </div>
                                        <div class="col">
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
@endsection