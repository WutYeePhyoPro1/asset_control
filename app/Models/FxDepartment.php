<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FxDepartment extends Model
{
    protected $connection = 'Fixasset';
    protected $table = 'asset.fxassetdetail';

//     public function operators(): HasMany
//     {
//         return $this->hasMany(Operator::class, 'asset_code', 'fxassetdetailcode');
//     }
// }

}
