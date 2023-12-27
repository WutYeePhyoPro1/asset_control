<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonRemark extends Model
{
    use HasFactory;
    protected $fillable=[
        'doc_no',
        'emp_id',
        'name',
        'branch',
        'department',
        'contract',
        'remark',
        'rank',
        'date'
    ];
}
