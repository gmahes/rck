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
                        <p class="card-text fw-bold text-dark fs-5">XML Coretax</p>
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
                                <p class="card-text fw-bold">Upload Excel Rekap Invoice</p>
                                <form action="{{ route('convert-xls-to-xml') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p class="card-text">Pilih File</p>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="file" class="form-control form-control-sm" name="file"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-auto d-flex">
                                            <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col mt-2">

                            </div>
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
                                    <p class="card-text fw-bold">Tabel Invoice</p>
                                    @if(isset($invoices))
                                    <table class="table table-bordered">
                                        <tr class="text-center table-dark">
                                            <th>No</th>
                                            <th>Pelanggan</th>
                                            <th>Tanggal Invoice</th>
                                            <th>No Invoice</th>
                                            <th>Sub Total</th>
                                            <th>Status</th>
                                        </tr>
                                        @foreach($invoices as $invoice)
                                        <tr>
                                            <td class="fw-bold">{{ $loop->iteration }}</td>
                                            <td>{{ $invoice['pelanggan'] }}</td>
                                            <td>{{ $invoice['tgl_invoice'] }}</td>
                                            <td>{{ $invoice['no_invoice'] }}</td>
                                            <td>{{ number_format($invoice['sub_total'], 0, ',', '.') }}</td>
                                            <td class=@if($invoice['status']=='Tidak Terdaftar' ) "text-danger" @endif>
                                                {{ $invoice['status'] }}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</main><!-- End #main -->
@endsection