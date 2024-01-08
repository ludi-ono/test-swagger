<?php

namespace App\Imports;

use App\Models\Import\ImportAbsensiDtlModels;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AbsensiImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        // die();
        // HeadingRowFormatter::default('none');
        return new ImportAbsensiDtlModels([
            // // 'nik' => $row[0],
            // // 'nama' => $row[1] ?? "", 
            // // 'tanggal' => $row[2] ?? "2021-07-01", 
            // // 'status' => $row[3] ?? "", 
            // 'nik' => $row['nik'],
            // 'nama' => $row['nama'] ?? "", 
            // 'tanggal' => $row['tanggal'] ?? "2021-07-01", 
            // 'status' => $row['status'] ?? "", 
            'nik' => $row['nik'],
            'nama' => $row['nama'] ?? "", 
            'tanggal' => date("Y/m/d H:i:s",strtotime($row['waktu'])), 
            // 'status' => $row['status'] ?? "", 
        ]);
    }
}
