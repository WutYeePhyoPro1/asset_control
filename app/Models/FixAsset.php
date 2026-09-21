<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixAsset extends Model
{
    use HasFactory;

    // fix_assets is stored in the application's local database.
    protected $connection = 'pgsql';

    protected $fillable = [
        'asset_code',
        'branch_code',
        'branch_name',
        'department',
        'asset_type_name',
        'asset_name',
        'purchase_date',
        'stop_cal_date',
        'status',
        'employee_data'
    ];

    protected $casts = [
        'employee_data' => 'array',
    ];
}
