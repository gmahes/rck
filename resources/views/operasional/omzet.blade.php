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
                                    <form action="" method="POST">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p class="card-text">Supir</p>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-select form-select-sm"
                                                    aria-label=".form-select-sm example">
                                                    <option selected>Pilih Supir</option>
                                                    <option value="1">Supir 1</option>
                                                    <option value="2">Supir 2</option>
                                                    <option value="3">Supir 3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-3">
                                                <p class="card-text fs-6">Tanggal Awal</p>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-3">
                                                <p class="card-text fs-6">Tanggal Akhir</p>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-auto d-flex">
                                                <button type="submit" class="btn btn-sm btn-primary">Cari Data</button>
                                                {{-- <button type="button" class="ms-1 btn btn-sm btn-primary">Unduh
                                                    Data</button> --}}
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col">
                                    <p class="card-text fw-bold fs-6 mt-2">Tambah Data</p>
                                    <form action="" method="POST">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p class="card-text">Supir</p>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-select form-select-sm"
                                                    aria-label=".form-select-sm example">
                                                    <option selected>Pilih Supir</option>
                                                    <option value="1">Supir 1</option>
                                                    <option value="2">Supir 2</option>
                                                    <option value="3">Supir 3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-3">
                                                <p class="card-text fs-6">Tanggal</p>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-md-3">
                                                <p class="card-text fs-6">Omzet</p>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control form-control-sm">
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
            <div class="row visually-hidden">
                <div class="col">
                    <div class="card mt-1 shadow">
                        <div class="card-body">
                            <table class="table mt-3" data-toggle="table">
                                <thead class="table-dark">
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Nomor Kendaraan</th>
                                        <th>Input Omzet</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($omzets as $omzet)
                                    {{-- @include('masters.omzets.modals.editomzet') --}}
                                    {{-- @include('masters.omzets.modals.deleteomzet') --}}
                                    <tr>
                                        <td class="fw-bold text-center">{{ $loop->iteration }}</td>
                                        <td class="">{{ $omzet->drivers->fullname }}</td>
                                        <td>{{ $omzet->drivers->vehicle_number }}</td>
                                        <td>{{ $omzet->drivers->vehicle_type }}</td>
                                        <td class="text-center">
                                            <div class="btn-group dropstart">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-justify"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <button type="button"
                                                            class="btn btn-sm dropdown-item text-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editomzet{{ $omzet->id }}">
                                                            <i class="bi bi-pencil"></i>
                                                            Edit Data
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button type="button"
                                                            class="btn btn-sm dropdown-item text-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteomzet{{ $omzet->id }}">
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
    </section>
</main>
@endsection