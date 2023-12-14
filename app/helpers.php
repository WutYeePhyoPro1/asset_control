<?php

use App\Models\Remark;
use App\Models\Operator;

function getRemark($asset_co)
{
    $remarks = Remark::where(['asset_code' => $asset_co])->first();
    // dd($remarks);
    return $remarks;
}

function getOperator($asset_co)
{
    $remarks = Operator::where(['asset_code' => $asset_co])->get();
    // dd($remarks);
    return $remarks;
}

function getOperatorL($asset_co)
{
    $remarks = Operator::where(['asset_code' => $asset_co])->lastet()->limit(1);
    // dd($remarks);
    return $remarks;
}
