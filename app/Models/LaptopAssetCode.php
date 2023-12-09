<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaptopAssetCode extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'doc_no',
        'type',
        'emp_name',
        'emp_code',
        'branch_code',
        'branch_name',
        'department',
        'receipt_date',
        'receipt_type',
        'remark',
        'file',
        'date'
    ];

    public function assetUpload(){
        return $this->belongsTo(Assetfile::class,'doc_id','id')->withDefault();
    }


    public function assetUploada(){
        return $this->hasMany(Assetfile::class,'doc_id');
    }

}
