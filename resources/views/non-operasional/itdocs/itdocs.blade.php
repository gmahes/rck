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
                                <p class="card-text fw-bold text-dark fs-5">Dokumentasi IT</p>
                            </div>
                            <div class="col text-end">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addITDocs">
                                    Tambah Data
                                </button>
                                @include('non-operasional.itdocs.modals.addITDocs')
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
                        <div class="row mt-2">
                            <div class="col">
                                <table data-toggle="table" data-search="true" data-pagination="true" id="itdocs"
                                    class="table table-bordered" style="width:100%">
                                    <thead class="table-dark">
                                        <tr class="text-center">
                                            <th data-width="165" class="fw-bold">ID</th>
                                            <th>Pengguna</th>
                                            <th>Permasalahan</th>
                                            <th>Tindakan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($troubles as $item)
                                        @include('non-operasional.itdocs.modals.deleteITDocs')
                                        <tr>
                                            <td>{{ $item->troubleID }}</td>
                                            <td>{{ $item->userDetail->fullname}}</td>
                                            <td>{{ $item->trouble }}</td>
                                            <td>@if ($item->action == null)
                                                {{ "-" }}
                                                @else {{ $item->action }}
                                                @endif</td>
                                            <td>@if ($item->status == "Belum Selesai")
                                                <i class="bi bi-hourglass-split text-primary fs-4"
                                                    title="Belum Selesai"></i>
                                                @else <i class="bi bi-check-square-fill text-success fs-4"
                                                    title="Selesai"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group dropstart">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-justify"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <button type="button"
                                                                class="btn btn-sm dropdown-item text-success"
                                                                data-bs-toggle="modal" data-bs-target="#editBupotList">
                                                                <i class="bi bi-pencil"></i>
                                                                Edit Data
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button type="button"
                                                                class="btn btn-sm dropdown-item text-danger"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteITDocs{{ $item->troubleID }}">
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