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
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop">
                                        Tambah Data
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title text-dark fw-bold fs-5"
                                                        id="staticBackdropLabel">
                                                        Tambah Data
                                                        Karyawan
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-start text-dark">
                                                    <form action="">
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <label for="username"
                                                                        class="form-label">Username</label>
                                                                </div>
                                                                <div class="col-8">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="username" placeholder="Masukkan Username"
                                                                        name="username">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <label for="nik" class="form-label">NIK</label>
                                                                </div>
                                                                <div class="col-8">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm" id="nik"
                                                                        placeholder="Masukkan NIK" name="nik">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <label for="position"
                                                                        class="form-label">Jabatan</label>
                                                                </div>
                                                                <div class="col-8">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="position" placeholder="Masukkan Jabatan"
                                                                        name="position">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <label for="role" class="form-label">Role</label>
                                                                </div>
                                                                <div class="col-8">
                                                                    <select class="form-select form-select-sm"
                                                                        aria-label="role">
                                                                        <option selected>Pilih Role User</option>
                                                                        <option value="1">One</option>
                                                                        <option value="2">Two</option>
                                                                        <option value="3">Three</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-2">
                                                            <div class="d-flex flex-row-reverse">
                                                                <div class="text-end">
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-primary">Simpan</button>
                                                                </div>
                                                                <div class="text-end me-2">
                                                                    <button type="button"
                                                                        class="btn btn-secondary btn-sm"
                                                                        data-bs-dismiss="modal">Tutup</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="card mt-4 border border-dark-subtle shadow">
                                <div class="card-body">
                                    <table class="table mt-2" data-toggle="table">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Item ID</th>
                                                <th>Item Name</th>
                                                <th>Item Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Item 1</td>
                                                <td>$1</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Item 2</td>
                                                <td>$2</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
@endsection