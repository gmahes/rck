@extends('layouts.index')
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Selamat Datang di RCK Office!</h1>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="col">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    <p class="card-text fw-bold text-dark fs-5">Data Supir</p>
                                </div>
                                <div class="col text-end">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addDriver">
                                        Tambah Data
                                    </button>
                                    @include('masters.drivers.modals.addDriver')
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
                            <table class="table mt-3" data-toggle="table" data-pagination="true">
                                <thead class="table-dark">
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Nomor Kendaraan</th>
                                        <th>Jenis Kendaraan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($drivers as $driver)
                                    @include('masters.drivers.modals.editDriver')
                                    @include('masters.drivers.modals.deleteDriver')
                                    <tr>
                                        <td class="fw-bold text-center">{{ $loop->iteration }}</td>
                                        <td class="">{{ $driver->fullname }}</td>
                                        <td>{{ $driver->vehicle_number }}</td>
                                        <td>{{ $driver->vehicle_type }}</td>
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
                                                            data-bs-target="#editDriver{{ $driver->id }}">
                                                            <i class="bi bi-pencil"></i>
                                                            Edit Data
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button type="button"
                                                            class="btn btn-sm dropdown-item text-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteDriver{{ $driver->id }}">
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
</main><!-- End #main -->
@endsection