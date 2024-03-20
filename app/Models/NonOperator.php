<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonOperator extends Model
{
    use HasFactory;
    protected $fillable=[
        'doc_no',
        'branch',
        'department',
        'operator',
        'phone',
    ];
}
