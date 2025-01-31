@extends('layouts.index')
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Selamat Datang di RCK Office!</h1>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <p class="card-text fw-bold text-dark fs-5">Fitur Coretax</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-2">
                                <p class="card-text fw-bold">Download XML Coretax</p>
                                <form action="{{ route('convert-xls-to-xml') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p class="card-text">Upload Rekap BOA => </p>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="file" class="form-control form-control-sm" name="file"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-auto d-flex">
                                            <button type="submit" class="btn btn-sm btn-primary">Download XML</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col mt-2">
                                <p class="card-text fw-bold">Download Excel Perhitungan DPP</p>
                                <form action="{{ route('download-dpp-excel') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p class="card-text">Upload Rekap BOA =></p>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="file" class="form-control form-control-sm" name="file" required
                                                placeholder="Klik Disini">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-auto d-flex">
                                            <button type="submit" class="btn btn-sm btn-primary">Download Excel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
@endsection