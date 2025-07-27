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
                                    <p class="card-text fw-bold text-dark fs-5">Kategori Pengaduan</p>
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
                                        <th>Kategori</th>
                                        <th>Jenis</th>
                                        <th data-width="10">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                    <tr>
                                        <td class="fw-bold text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $category->name }}</td>
                                        <td class="text-center">{{ $category->type }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('delete-category', $category->name) }}"
                                                class="btn btn-sm btn-danger" data-confirm-delete="true"><i
                                                    class="bi bi-trash-fill fs-6"></i></a>
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
                                    <p class="card-text text-center fw-bold text-dark fs-5">Tambah Kategori</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('add-category') }}" method="POST">
                                @csrf
                                <div class="mb-3 mt-2">
                                    <label for="categoryName" class="form-label">Nama Kategori</label>
                                    <input type="text" class="form-control form-control-sm" id="categoryName"
                                        name="categoryName" required autocomplete="off">
                                </div>
                                <div class="mb-3">
                                    <label for="categoryType" class="form-label">Jenis Kategori</label>
                                    <select name="categoryType" id="categoryType"
                                        class="selectpicker form-control form-control-sm" required>
                                        <option value="" disabled selected>Pilih Jenis Kategori</option>
                                        @foreach ($categoryTypes as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
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