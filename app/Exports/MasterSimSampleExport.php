<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class MasterSimSampleExport implements FromArray, WithColumnFormatting, WithHeadings
{
    public function headings(): array
    {
        return ['No', 'Simcard', 'Type'];
    }

    public function array(): array
    {
        return [
            [1, '0979XXXXXXX', 'Available'],
            [2, '0979XXXXXXX', 'Used'],
            [3, '0979XXXXXXX', 'Reserve'],
        ];
    }

    public function columnFormats(): array
    {
        // Keep SIM numbers as text so leading zeroes are not removed by Excel.
        return [
            'B' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
