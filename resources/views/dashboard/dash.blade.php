@extends('layouts.index')
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Selamat Datang di RCK Helpdesk!</h1>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $fullname }}</h5>
                        <img src="{{ asset('img/avatar.jpg') }}" class="img-fluid" alt="">
                        @if (Auth::user()->role != 'superadmin')
                        <h3 class="card-title fs-6">{{ $position->name }}</h3>
                        @endif
                    </div>
                </div>
            </div>
            {{-- <div class="col">
                <div class="card">
                    <div class="row">
                        {{ $chart->container() }}
                    </div>
                </div>
            </div> --}}
        </div>
    </section>
</main><!-- End #main -->
@endsection