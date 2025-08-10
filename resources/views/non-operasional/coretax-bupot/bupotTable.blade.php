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
                                <form action="{{ route('filter-bupot') }}" method="POST" id="formFilterBupot">
                                    @csrf
                                    <div class="row mt-1">
                                        <div class="col-md-4">
                                            <p class="card-text mt-1 fs-6">Tanggal Awal</p>
                                        </div>
                                        <div class="col">
                                            <input type="date" class="form-control form-control-sm" name="start_date"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-md-4">
                                            <p class="card-text mt-1 fs-6">Tanggal Akhir</p>
                                        </div>
                                        <div class="col">
                                            <input type="date" class="form-control form-control-sm" name="end_date"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <label for="sbu">SBU</label>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="ckl"
                                                    id="checkDefault" name="sbu">
                                                <label class="form-check-label" for="checkDefault">
                                                    CKL
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form action="{{ route('xmlBupot') }}" method="POST" id="xmlBupot">
                                    @csrf
                                    <input type="hidden" name="filteropt" value="{{ session('filteropt') }}">
                                    <input type="hidden" name="start_date" value="{{ session('start_date') }}">
                                    <input type="hidden" name="end_date" value="{{ session('end_date') }}">
                                </form>
                                <div class="row mt-3">
                                    <div class="col-auto d-flex">
                                        <button type="submit" class="btn btn-sm btn-primary" form="formFilterBupot">Cari
                                            Data</button>
                                        <button type="submit" class="btn btn-sm btn-warning ms-2"
                                            form="xmlBupot">Download XML</button>
                                        {{-- <a class="btn btn-sm btn-success ms-2">Download Excel</a> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col">

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
                        <div class="row mt-1">
                            <p class="card-text fw-bold">List Bupot {{
                                \Carbon\Carbon::parse(session()->get('start_date'))->translatedFormat('d M Y') . ' - '.
                                \Carbon\Carbon::parse(session()->get('end_date'))->translatedFormat('d M
                                Y') }}</p>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" data-toggle="table"
                                        data-pagination="true" data-search="true">
                                        <thead class="table-dark text-center">
                                            <tr>
                                                <th>No</th>
                                                <th>Tgl Dokumen</th>
                                                <th>Nama Supplier</th>
                                                <th>No Dokumen</th>
                                                <th>DPP</th>
                                                <th>PPh</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bupots as $bupot)
                                            @include('non-operasional.coretax-bupot.modals.deleteBupotList')
                                            @include('non-operasional.coretax-bupot.modals.editBupotList')
                                            <tr>
                                                <td class="fw-bold text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{
                                                    \Carbon\Carbon::parse($bupot->date)->translatedFormat('d M Y') }}
                                                </td>
                                                <td>{{ $bupot->supplier->name }}</td>
                                                <td class="text-center">{{ $bupot->docId }}</td>
                                                <td class="text-center">{{ "Rp ".$bupot->dpp }}</td>
                                                <td class="text-center">{{ "Rp ".$bupot->pph }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group dropstart">
                                                        <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                            type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="bi bi-justify"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <button type="button"
                                                                    class="btn btn-sm dropdown-item text-success"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editBupotList{{ $bupot->id }}">
                                                                    <i class="bi bi-pencil"></i>
                                                                    Edit Data
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button type="button"
                                                                    class="btn btn-sm dropdown-item text-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#deleteBupotList{{ $bupot->id }}">
                                                                    <i class="bi bi-trash"></i>
                                                                    Hapus Data
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
@endsection