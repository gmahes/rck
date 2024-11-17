<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dummy</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('img/rck.png') }}" rel="icon">
    <link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-table-master/dist/bootstrap-table.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- =======================================================
        * Template Name: NiceAdmin
        * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
        * Updated: Apr 20 2024 with Bootstrap v5.3.3
        * Author: BootstrapMade.com
        * License: https://bootstrapmade.com/license/
        ======================================================== -->
</head>

<body style="background-color: white">
    <div class="container">
        <section class="section">
            <div class="row">
                <div class="col">
                    <br><br><br>
                    <h1 class="text-center text-dark fw-bold">Target Omzet</h1>
                    <p class="text-center text-dark">PT. Roda Chakra Kencana</p>
                    <br><br>
                    <p class="text-dark">Periode : {{ date('d F Y', $filter['start_date']). ' - '. date('d F Y',
                        $filter['end_date'])}}</p>
                    @if ($supir == null)
                    <table class="table table-bordered border-dark mt-3 align-items-center">
                        <thead>
                            <tr class="text-center">
                                <th>Nama Lengkap</th>
                                <th>Nomor Kendaraan</th>
                                <th>Jenis Kendaraan</th>
                                <th>Omzet</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($drivers as $driver)
                            <tr class="text-center">
                                <td>{{ $driver->fullname }}</td>
                                <td>{{ $driver->vehicle_number }}</td>
                                <td>{{ $driver->vehicle_type }}</td>
                                <td class="fw-bold">
                                    {{ "Rp".number_format($totalOmzetPerDriver[$driver->id] ?? 0, 0, ',', '.')
                                    }}
                                </td>
                            </tr>
                            @endforeach
                            <tr class="text-center">
                                <td colspan="3" class="fw-bold">Total Omzet</td>
                                <td class="fw-bold">{{ "Rp".($totalOmzet) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @else
                    <table class="table table-bordered border-dark mt-3">
                        <thead>
                            <tr class="text-center">
                                <th>Nama Lengkap</th>
                                <th>Nomor Kendaraan</th>
                                <th>Jenis Kendaraan</th>
                                <th>Omzet</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td>{{ $supir->first()->fullname }}</td>
                                <td>{{ $supir->first()->vehicle_number }}</td>
                                <td>{{ $supir->first()->vehicle_type }}</td>
                                <td class="fw-bold">{{ "Rp".$totalOmzet }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </section>
    </div>
    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-table-master/dist/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('js/main.js') }}"></script>
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
</body>

</html>