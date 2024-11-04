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
                            <div class="row">
                                <div class="col">
                                    <p class="card-text fw-bold text-primary-emphasis fs-5">Target Omzet</p>
                                </div>
                                <div class="col text-end">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addOmzet">
                                        Tambah Data
                                    </button>
                                    @include('operasional.modals.addOmzet')
                                </div>
                                <hr class="text-dark mt-2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
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