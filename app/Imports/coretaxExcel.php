<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithStartRow;

class coretaxExcel implements ToArray, WithStartRow
{
    public $data = [];
    public function startRow(): int
    {
        return 2;
    }
    public function array(array $rows)
    {
        foreach ($rows as $row) {
            // Periksa apakah ada cell yang kosong
            // if (empty($row[1]) || empty($row[3]) || empty($row[4]) || empty($row[7])) {
            //     continue; // Lewati baris ini
            // }
            $this->data[] =
                [
                    'no_invoice' => $row[13],
                    'nama_pelanggan' => $row[1],
                    'sub_total' => $row[8],
                ];
        }
    }
}
