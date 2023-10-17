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
        'asset_type',
        'laptop_asset_code',
        'laptop_asset_name',
        'handset_asset_code',
        'handset_asset_name',
        'sim_name',
        'sim_phone',
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
