<?php

namespace App\Imports;

use App\Models\Customers;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;


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
            $deskripsi = explode(';', $row[3]);
            $unit = explode(';', $row[4]);
            $jumlah = explode(';', $row[5]);
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
