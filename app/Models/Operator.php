<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;
    protected $fillable=[
        'asset_code',
        'branch',
        'department',
        'asset_type',
        'asset_name',
        'operator',
        'phone',
    ];

}
