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
                        <p class="card-text fw-bold text-dark fs-5">Fitur Coretax</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-2">
                                <p class="card-text fw-bold">Download XML Coretax</p>
                                <form action="{{ route('convert-xls-to-xml') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-5 mt-1">
                                            <p class="card-text">Upload Rekap BOA => </p>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="file" class="form-control form-control-sm" name="file"
                                                required>
                                        </div>
                                    </div>
                                    @if (auth()->user()->role == 'administrator' or auth()->user()->role ==
                                    'superadmin' or auth()->user()->userDetail->position == 'Admin Marketing' or
                                    auth()->user()->userDetail->position == 'Admin Akuntansi' or
                                    auth()->user()->userDetail->position == 'Staff Exim' or
                                    auth()->user()->userDetail->position == 'Kepala Exim')
                                    <div class="row mt-1">
                                        <div class="col">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="invoice"
                                                    id="invoiceExp" value="exp" required>
                                                <label class="form-check-label" for="invoiceExp">Angkutan</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="invoice"
                                                    id="invoiceImport" value="imp">
                                                <label class="form-check-label" for="invoiceImport">Import</label>
                                            </div>
                                            <div class="form-check form-check-inline" {{ auth()->
                                                user()->userDetail->position == 'Admin Marketing' ||
                                                auth()->user()->userDetail->position == 'Staff Exim' ||
                                                auth()->user()->userDetail->position == 'Kepala Exim' ? 'hidden' : ''
                                                }}>
                                                <input class="form-check-input" type="radio" name="invoice"
                                                    id="invoiceBengkel" value="bkl">
                                                <label class="form-check-label" for="invoiceBengkel">Bengkel</label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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
                                        <div class="col-md-5 mt-1">
                                            <p class="card-text">Upload Rekap BOA =></p>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="file" class="form-control form-control-sm" name="file" required
                                                placeholder="Klik Disini">
                                        </div>
                                    </div>
                                    @if (auth()->user()->role == 'administrator' or auth()->user()->role ==
                                    'superadmin' or auth()->user()->userDetail->position == 'Admin Marketing' or
                                    auth()->user()->userDetail->position == 'Admin Akuntansi')
                                    <div class="row mt-1">
                                        <div class="col">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="invoice"
                                                    id="invoiceExpDpp" value="exp" required>
                                                <label class="form-check-label" for="invoiceExpDpp">Angkutan</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="invoice"
                                                    id="invoiceImportDpp" value="imp">
                                                <label class="form-check-label" for="invoiceImportDpp">Import</label>
                                            </div>
                                            <div class="form-check form-check-inline" {{ auth()->
                                                user()->userDetail->position == 'Admin Marketing' ? 'hidden' : '' }}>
                                                <input class="form-check-input" type="radio" name="invoice"
                                                    id="invoiceBengkelDpp" value="bkl">
                                                <label class="form-check-label" for="invoiceBengkelDpp">Bengkel</label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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
        @if (auth()->user()->userDetail->position == 'Admin Akuntansi' or auth()->user()->role == 'administrator' or
        auth()->user()->role == 'superadmin')
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-2">
                                <p class="card-text fw-bold">Koreksi Faktur Pajak</p>
                                <form action="{{ route('tax-invoice-correction') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p class="card-text">Excel Coretax => </p>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="file" class="form-control form-control-sm" name="coretaxExcel"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-5">
                                            <p class="card-text">Excel Akunting => </p>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="file" class="form-control form-control-sm"
                                                name="accountingExcel" required>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-auto d-flex">
                                            <button type="submit" class="btn btn-sm btn-primary">Koreksi Faktur</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </section>
</main><!-- End #main -->
@endsection