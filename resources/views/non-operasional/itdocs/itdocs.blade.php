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
                                            <th>Gambar</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($troubles as $item)
                                        <tr>
                                            <td>{{ $item->troubleID }}</td>
                                            <td>{{ $item->userDetail->fullname}}</td>
                                            <td>{{ $item->trouble }}</td>
                                            <td>@if ($item->action == null)
                                                {{ "Belum ada aksi" }}
                                                @else {{ $item->action }}
                                                @endif</td>
                                            <td>{{ $item->status }}</td>
                                            <td></td>
                                            <td>
                                                <img src="{{ Storage::url($item->photo) }}" alt="" width="200">
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