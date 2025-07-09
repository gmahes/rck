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
                            {{-- @if (Auth::user()->role == 'user')
                            <div class="col text-end">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addComplaint">
                                    Buat Pengaduan
                                </button>
                                @include('helpdesk.complaints.modals.addComplaint')
                            </div>
                            @endif --}}
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
                                            <th>Permasalahan</th>
                                            <th>Solusi</th>
                                            <th>Waktu Selesai</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($troubleHistory as $item)
                                        <tr>
                                            <td>{{ $item->troubleID }}</td>
                                            @if (Auth::user()->role != 'user')
                                            <td>{{ $item->userDetail->fullname}}</td>
                                            @endif
                                            <td>{{ $item->trouble }}</td>
                                            <td>{{ $item->action }}</td>
                                            <td>{{ $item->updated_at }}</td>
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