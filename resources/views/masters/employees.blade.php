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
                                    <p class="card-text fw-bold text-primary-emphasis fs-5">Data Karyawan</p>
                                </div>
                                <div class="col text-end">
                                    @include('components.masters.modals.addEmployee')
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
                            <table class="table mt-3" data-toggle="table">
                                <thead class="table-dark">
                                    <tr class="text-center">
                                        <th>NIK</th>
                                        <th>Nama Lengkap</th>
                                        <th>Jabatan</th>
                                        <th>Role</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $employee)
                                    <tr>
                                        <td class="fw-bold">{{ $employee->nik }}</td>
                                        <td class="">{{ $employee->fullname }}</td>
                                        <td>{{ $employee->position }}</td>
                                        <td>{{ $employee->userAuth->role }}</td>
                                        <td class="text-center">
                                            <div class="btn-group dropstart">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-justify"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{ route('del-employee', $employee->username) }}"
                                                            class="btn btn-sm btn-danger"
                                                            data-confirm-delete="true">Hapus</a>
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