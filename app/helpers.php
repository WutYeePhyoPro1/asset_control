<?php

use App\Models\Remark;

function getRemark($asset_co)
{
    $remarks = Remark::where(['asset_code' => $asset_co])->get();
    // dd($remarks);
    return $remarks;
}
