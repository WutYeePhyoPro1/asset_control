<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    use HasFactory;
    protected $fillable=[
        'doc_id',
        'department',
        'branch',
        'assettype',
        'assetcode',
        'assetname',
        'operator',
        'ph'
    ];
}
