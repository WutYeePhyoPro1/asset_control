<?php

namespace App\Exports;
use App\Models\LaptopAssetCode;
use Maatwebsite\Excel\Concerns\FromCollection;

class LaptopAssetCodeExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LaptopAssetCode::select('doc_no', 'type', 'emp_name','emp_code','branch_code','branch_name','department','asset_type','laptop_asset_code','laptop_asset_name','handset_asset_code','handset_asset_name','sim_name','sim_phone','receipt_type','remark','date','created_at')->get();
    }
}
