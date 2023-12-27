<?php

namespace App\Imports;
use App\Models\NonOperator;
use App\Models\NonRemark;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;
class NonAssetOperator implements ToModel, WithHeadingRow, WithValidation
{
    // /**
    // * @param Collection $collection
    // */

    // /**
    //  * @param array $row
    //  * @return Operator
    //  */
    public function model(array $row)
    {
        $date = Carbon::today()->format('Ymd');

        $today = NonRemark::whereDate('created_at',Carbon::today())->get();
        //
        $suffix = $today->isEmpty() ? 1 : $today->count() + 1;

        $data = sprintf("%'.04d", $suffix);

        $doc_no = 'NASOP' . $date . '-' . $data;
        // dd($doc_no);
        $re = new NonRemark([
            'doc_no' => $doc_no,
            'contract' => $row['contract'],
            'branch' => $row['branch'],
            'department' => $row['department'],
            'emp_id' => $row['emp_id'],
            'name' => $row['name'],
            'remark' => $row['remark'],
            'date'      => Carbon::now()
        ]);

        $re->save();

        $op = new NonOperator([
            'doc_no' => $re->doc_no,
            'branch' => $row['branch'],
            'department' => $row['department'],
            'operator' => $row['operator'],
            'phone' => $row['phone'],
        ]);

        $op->save();

        return $re;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'branch'   => 'required',
            'emp_id'   => 'required',
            'emp_id'   => 'required',
            'name'     => 'required',
            'operator' => 'required',
            'phone'    => 'required',
            'contract' => 'required',
            'remark'   => 'required',
        ];
    }

}
