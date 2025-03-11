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
                        <p class="card-text fw-bold text-dark fs-5">Bukti Potong PPh</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row mt-1">
                            <p class="card-text fw-bold">Data Supplier</p>
                            <form action="{{ route('save-bupot') }}" method="POST">
                                @csrf
                                @livewire('get-supplier')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @isset($listBupot)
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row mt-1">
                            <p class="card-text fw-bold">Tabel Data Bupot</p>
                            <table class="table" data-toggle="table" data-pagination="true" data-search="true">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Supplier</th>
                                        <th>Tanggal Dokumen</th>
                                        <th>Nomor Dokumen</th>
                                        <th>DPP</th>
                                        <th>Tanggal Potong</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listBupot as $bupot)
                                    {{ dump($bupot) }}
                                    {{-- <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $bupot->supplier }}</td>
                                        <td>{{ $bupot->date }}</td>
                                        <td>{{ $bupot->docId }}</td>
                                        <td>{{ $bupot->dpp }}</td>
                                        <td>{{ $bupot->whdate }}</td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endisset
    </section>
</main><!-- End #main -->
@endsection