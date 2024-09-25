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
                    <div class="card-body mx-auto">
                        <h5 class="card-title">Example Card</h5>
                        <img src="{{ asset('img/avatar.jpg') }}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
@endsection