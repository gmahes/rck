<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="container" style="">
        <br><br>
        <h1 style="text-align: center">Target Omzet</h1>
        <p style="text-align: center">PT. Roda Chakra Kencana</p>
        <br><br>
        <p style="text-align: center">Periode : {{ date('d F Y', $filter['start_date']). ' - '. date('d F Y',
            $filter['end_date'])}}</p>
        @if ($supir == null)
        <table style="margin-left: auto; margin-right: auto;text-align: center; width: 85%; border-collapse: collapse"
            border="1px">
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
                    <td>
                        {{ "Rp".number_format($totalOmzetPerDriver[$driver->id] ?? 0, 0, ',', '.')
                        }}
                    </td>
                </tr>
                @endforeach
                <tr class="text-center">
                    <th colspan="3">Total Omzet</th>
                    <td>{{ "Rp".($totalOmzet) }}</td>
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
                    <td>
                        <p style="text-decoration-style: solid">{{ "Rp".$totalOmzet }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        @endif
    </div>
</body>

</html>