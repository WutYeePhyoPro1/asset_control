<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\LaptopAssetCode;
use App\Models\Operator;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class OperatorImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    public $rowCount;
    public $rowLimit;

    public function __construct($rowLimit)
    {
        $this->rowCount = 0;
        $this->rowLimit = $rowLimit;
    }

    public function model(array $row)
    {
        if ($this->rowCount >= $this->rowLimit) {
            return null;
        }

        $new = new Operator();
        $new->branch_name = $row['branch_name'];
        $new->department = $row['department'];
        $new->asset_type = $row['asset_type'];
        $new->asset_code = $row['asset_code'];
        $new->asset_name = $row['asset_name'];
        $new->operator = $row['operator'];
        $new->phone = $row['phone'];

        $new->save();

        $this->rowCount++;
        return $new;
    }

    public function rules(): array
    {
        return [
            'asset_code' => 'required',
            'branch_name' => 'required',
            'department' => 'required',
            'asset_type' => 'required',
            'asset_name' => 'required',
            'operator' => 'required',
            'phone' => 'required',
        ];
    }
}
