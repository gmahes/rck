<?php

namespace App\Imports;

use App\Models\Customers;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class xls implements ToArray, WithHeadingRow, WithStartRow
{
    public $data = [];
    public function startRow(): int
    {
        return 5;
    }
    public function array(array $rows)
    {
        foreach ($rows as $row) {
            $customer = Customers::where('name', $row[1])->first();
            if ($customer) {
                $status = 'Terdaftar';
            } else {
                $status = 'Tidak Terdaftar';
            }
            // Periksa apakah ada cell yang kosong
            if (empty($row[1]) || empty($row[3]) || empty($row[4]) || empty($row[7])) {
                continue; // Lewati baris ini
            }
            $this->data[] = [ // Sesuaikan dengan header di Excel
                'pelanggan'  => rtrim($row[1]),
                'tgl_invoice' => $row[3],
                'no_invoice'  => $row[4],
                'sub_total'  => floatval($row[7]),
                'status' => $status
            ];
        }
    }
}
