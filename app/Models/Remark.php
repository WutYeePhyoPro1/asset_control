<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    use HasFactory;
    protected $fillable=[
        'asset_code',
        'emp_id',
        'emp_name',
        'operator',
        'phone',
        'contract',
        'remark',
        'rank',
        'branch_name',
        'department',
        'sub_department',
    ];

    public function Remarkelq(){
        return $this->belongsTo(Operator::class,'asset_code')->withDefault();
    }

}
