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
                                    <p class="card-text fw-bold text-dark fs-5">Data Pelanggan</p>
                                </div>
                                @if (auth()->user()->role == 'superadmin' or auth()->user()->role == 'administrator')
                                <div class="col text-end">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addCustomer">
                                        Tambah Data
                                    </button>
                                    @include('masters.customers.modals.addCustomer')
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card mt-1 shadow">
                        <div class="card-body">
                            <table class="table" data-toggle="table" data-pagination="true" data-search="true">
                                <thead class="table-dark">
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Jenis Identitas</th>
                                        <th>Nomor Identitas</th>
                                        <th>Alamat Pelanggan</th>
                                        @if (auth()->user()->role == 'superadmin' or auth()->user()->role ==
                                        'administrator')
                                        <th>Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                    @include('masters.customers.modals.editCustomer')
                                    @include('masters.customers.modals.deleteCustomer')
                                    <tr>
                                        <td class="fw-bold text-center">{{ $loop->iteration }}</td>
                                        <td class="">{{ $customer->name }}</td>
                                        <td class="">{{ $customer->type }}</td>
                                        <td>{{ $customer->id }}</td>
                                        <td>{{ $customer->address }}</td>
                                        @if (auth()->user()->role == 'superadmin' or auth()->user()->role ==
                                        'administrator')
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
                                                            data-bs-target="#editCustomer{{ $customer->id }}">
                                                            <i class="bi bi-pencil"></i>
                                                            Edit Data
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button type="button"
                                                            class="btn btn-sm dropdown-item text-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteCustomer{{ $customer->id }}">
                                                            <i class="bi bi-trash"></i>
                                                            Hapus Data
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        @endif
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