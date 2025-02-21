<?php

namespace App\Imports;

use App\Models\Customers;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Str;

class invoiceImport implements ToArray, WithStartRow
{
    public $data = [];
    public function startRow(): int
    {
        return 2;
    }
    public function array(array $array)
    {
        foreach ($array as $row) {
            $customer = Customers::where('name', $row[2])->first();
            if ($customer) {
                $status = 'Terdaftar';
            } else {
                $status = 'Tidak Terdaftar';
            }
            $deskripsi = Str::contains($row[3], ';') ? explode(';', $row[3]) : $row[3];
            $unit = Str::contains($row[4], ';') ? explode(';', $row[4]) : $row[4];
            $jumlah = Str::contains($row[5], ';') ? explode(';', $row[5]) : $row[5];
            $this->data[] = [
                'no_invoice' => $row[0],
                'tanggal_invoice' => Date::excelToDateTimeObject($row[1])->format('Y-m-d'),
                'nama_pelanggan' => $row[2],
                'deskripsi' => $deskripsi,
                'unit' => $unit,
                'jumlah' => $jumlah,
                'status' => $status,
            ];
        }
    }
}
