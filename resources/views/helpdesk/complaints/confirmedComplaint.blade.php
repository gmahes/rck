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
                                <p class="card-text fw-bold text-dark fs-5">Pengaduan Diproses</p>
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
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($confirmedTroubles as $item)
                                        @include('helpdesk.complaints.modals.editComplaint')
                                        @include('helpdesk.complaints.modals.deleteComplaint')
                                        <tr>
                                            <td>{{ $item->troubleID }}</td>
                                            @if (Auth::user()->role != 'user')
                                            <td>{{ $item->userDetail->fullname}}</td>
                                            @endif
                                            <td>{{ $item->trouble }}</td>
                                            <td>
                                                @if (Auth::user()->role == 'user')
                                                @if ($item->status == "Added")
                                                <div class="btn-group dropstart">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-justify"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <button type="button"
                                                                class="btn btn-sm dropdown-item text-success"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editComplaint{{ $item->troubleID }}">
                                                                <i class="bi bi-pencil"></i>
                                                                Edit
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button type="button"
                                                                class="btn btn-sm dropdown-item text-danger"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteComplaint{{ $item->troubleID }}">
                                                                <i class="bi bi-trash"></i>
                                                                Hapus
                                                        </li>
                                                    </ul>
                                                </div>
                                                @else
                                                @endif
                                                @endif
                                                @if (Auth::user()->role != 'user')
                                                @if ($item->status == "On Process")
                                                <div class="btn-group dropstart">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-justify"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <button type="button"
                                                                class="btn btn-sm dropdown-item text-success"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editComplaint{{ $item->troubleID }}">
                                                                <i class="bi bi-pencil"></i>
                                                                Edit
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                                @elseif ($item->status == "Added")
                                                <form action="{{ route('confirm-complaint') }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="troubleID"
                                                        value="{{ $item->troubleID }}">
                                                    <input type="hidden" name="status" value="On Process">
                                                    <button class="btn btn-sm btn-primary" type="submit">Proses</button>
                                                </form>
                                                @endif
                                                @endif
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