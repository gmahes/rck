@extends('layouts.index')
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Selamat Datang di RCK Helpdesk!</h1>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="col">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    <p class="card-text fw-bold text-dark fs-5">Data Jabatan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <table class="table" data-toggle="table" data-pagination="true" data-page-size="5"
                                data-search="true">
                                <thead class="table-dark">
                                    <tr class="text-center">
                                        <th data-width="10">No</th>
                                        <th>Jabatan</th>
                                        <th data-width="10">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($positions as $position)
                                    <tr>
                                        <td class="fw-bold text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $position->name }}</td>
                                        <td class="text-center">
                                            @if ($position->name !== 'Admin IT' && $position->name !== 'Teknisi IT')
                                            <a href="{{ route('delete-position', $position->name) }}"
                                                class="btn btn-sm btn-danger" data-confirm-delete="true"><i
                                                    class="bi bi-trash-fill fs-6"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    <p class="card-text text-center fw-bold text-dark fs-5">Tambah Jabatan</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('add-position') }}" method="POST">
                                @csrf
                                <div class="mb-3 mt-2">
                                    <label for="positionName" class="form-label">Nama Jabatan</label>
                                    <input type="text" class="form-control form-control-sm" id="positionName"
                                        name="positionName" required autocomplete="off">
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
@endsection