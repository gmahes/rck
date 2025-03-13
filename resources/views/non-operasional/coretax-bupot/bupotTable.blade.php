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
                        <div class="row mt-3">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-dark text-center">
                                            <tr>
                                                <th>No</th>
                                                <th>Tgl Potong</th>
                                                <th>Nama Supplier</th>
                                                <th>Tgl Dokumen</th>
                                                <th>DPP</th>
                                                <th>PPh</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bupots as $bupot)
                                            @include('non-operasional.coretax-bupot.modals.deleteBupotList')
                                            <tr>
                                                <td class="fw-bold text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{
                                                    \Carbon\Carbon::parse($bupot->whdate)->translatedFormat('d M Y')
                                                    }}</td>
                                                <td>{{ $bupot->supplier->name }}</td>
                                                <td class="text-center">{{
                                                    \Carbon\Carbon::parse($bupot->date)->translatedFormat('d M Y') }}
                                                </td>
                                                <td class="text-center">{{ "Rp ".$bupot->dpp }}</td>
                                                <td class="text-center">{{ "Rp ".$bupot->pph }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a type="button" data-bs-toggle="modal"
                                                            data-bs-target="#deleteBupot{{ $bupot->id }}"><i
                                                                class="bi bi-trash3-fill text-danger fs-5"></i>
                                                        </a>
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