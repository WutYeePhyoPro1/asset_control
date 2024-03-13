<?php

use App\Models\Remark;
use App\Models\NonRemark;
use App\Models\NonOperator;
use App\Models\Operator;

function getRemark($asset_co)
{
    $remarks = Remark::where(['asset_code' => $asset_co])->first();
    return $remarks;
}

function getRemark208($asset_co)
{
    $remarks = Remark::where(['asset_code' => $asset_co])->limit(1)->get();
    return $remarks;
}


function getRemark1($asset_co)
{
    $remarks = Remark::where(['asset_code' => $asset_co])->get();
    return $remarks;
}

function getOperator($asset_co)
{
    $operators = Operator::where(['asset_code' => $asset_co])->orderBy('id', 'desc')->get();
    return $operators;
}

function getOperatorL($asset_co)
{
    $operators1 = Operator::where(['asset_code' => $asset_co])->lastet()->limit(1);
    return $operators1;
}


function getnonRemark($doc_no)
{
    $remarks = NonRemark::where(['doc_no' => $doc_no])->first();
    return $remarks;
}

function getnonOperator($doc_no)
{
    $remarks = NonOperator::where(['doc_no' => $doc_no])->orderBy('id', 'desc')->get();
    return $remarks;
}

function getnonRemark208($doc_no)
{
    $remarks = NonRemark::where(['doc_no' => $doc_no])->limit(1)->get();
    return $remarks;
}

