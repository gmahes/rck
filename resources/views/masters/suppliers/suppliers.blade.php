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
                                    <p class="card-text fw-bold text-dark fs-5">Data Suppliers</p>
                                </div>
                                @if (auth()->user()->role == 'superadmin' or auth()->user()->role == 'administrator')
                                <div class="col text-end">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addSupplier">
                                        Tambah Data
                                    </button>
                                    @include('masters.suppliers.modals.addSupplier')
                                </div>
                                @endif
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
                        <table class="table" data-toggle="table" data-pagination="true" data-search="true">
                            <thead class="table-dark">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nomor Identitas</th>
                                    <th>Nama Supplier</th>
                                    <th>Kode Objek</th>
                                    <th>Persen</th>
                                    <th>Jenis Dokumen</th>
                                    <th>Fasilitas</th>
                                    @if (auth()->user()->role == 'superadmin' or auth()->user()->role ==
                                    'administrator')
                                    <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $supplier)
                                @include('masters.suppliers.modals.editSupplier')
                                @include('masters.suppliers.modals.deleteSupplier')
                                <tr>
                                    <td class="fw-bold text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $supplier->id }}</td>
                                    <td>{{ $supplier->name }}</td>
                                    <td class="text-center">{{ $supplier->code }}</td>
                                    <td class="text-center">{{ $supplier->percentage . "%" }}</td>
                                    <td class="text-center">{{ $supplier->document }}</td>
                                    <td class="text-center">{{ $supplier->facility }}</td>
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
                                                    <button type="button" class="btn btn-sm dropdown-item text-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editSupplier{{ $supplier->id }}">
                                                        <i class="bi bi-pencil"></i>
                                                        Edit Data
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" class="btn btn-sm dropdown-item text-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteSupplier{{ $supplier->id }}">
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
    </section>
</main><!-- End #main -->
@endsection