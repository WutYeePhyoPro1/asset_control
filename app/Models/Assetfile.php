<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assetfile extends Model
{
    use HasFactory;
    protected $fillable=[
        'doc_id',
        'file',
    ];
}
