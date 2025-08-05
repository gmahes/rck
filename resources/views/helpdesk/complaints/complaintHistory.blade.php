@extends('layouts.index')
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Selamat Datang di RCK Helpdesk!</h1>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <p class="card-text fw-bold text-dark fs-5">Riwayat Pengaduan</p>
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
                                            <th data-width="165" class="fw-bold">Trouble ID</th>
                                            @if (Auth::user()->role != 'user')
                                            <th>Pengguna</th>
                                            @endif
                                            <th>Kategori</th>
                                            <th>Permasalahan</th>
                                            <th>Solusi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($troubleHistory as $item)
                                        @include('helpdesk.complaints.modals.editComplaint')
                                        <tr>
                                            <td>{{ $item->troubleID }}</td>
                                            @if (Auth::user()->role != 'user')
                                            <td>{{ $item->userDetail->fullname}}</td>
                                            @endif
                                            <td>{{ $item->category->name }}</td>
                                            <td>{{ $item->trouble }}</td>
                                            <td>{{ $item->action }}</td>
                                            <td>
                                                <div class="d-inline-flex gap-3 align-items-center">
                                                    <a href="" data-bs-toggle="modal"
                                                        data-bs-target="#editComplaint{{ $item->troubleID }}"
                                                        title="Tindakan">
                                                        <i class="bi bi-eye-fill fs-4"></i>
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
    </section>
</main><!-- End #main -->
@endsection