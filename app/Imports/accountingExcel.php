<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class accountingExcel implements ToArray
{
    public $data = [];
    public function array(array $rows)
    {
        foreach ($rows as $row) {
            $this->data[] = [
                'no_invoice' => $row[0],
                'nama_pelanggan' => $row[1],
                'sub_total' => $row[2],
            ];
        }
    }
}
