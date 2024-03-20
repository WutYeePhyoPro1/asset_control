<?php

namespace App\Imports;

use App\Models\Operator;
use App\Models\Remark;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AssetOperator implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     * @return Operator
     */
    public function model(array $row)
    {
        $op = new Operator([
            'branch' => $row['branch_name'],
            'asset_code'  => $row['asset_code'],
            'department'  => $row['department'],
            'asset_type'  => $row['asset_type'],
            'asset_name'  => $row['asset_name'],
            'operator'    => $row['operator'],
            'phone'       => $row['phone'],
        ]);

        $op->save();

        $re = new Remark([
            'asset_code' => $op->asset_code,
            'contract'   => $row['contract'],
            'remark'     => $row['remark'],
        ]);

        $re->save();

        return $op;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'branch_name' => 'required',
            'asset_code'  => 'required',
            'department'  => 'required',
            'asset_type'  => 'required',
            'asset_name'  => 'required',
            'operator'    => 'required',
            'phone'       => 'required',
            'contract'    => 'required',
            'remark'      => 'required',
        ];
    }
}
