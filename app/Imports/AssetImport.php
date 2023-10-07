<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\LaptopAssetCode;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AssetImport implements ToModel, 
WithHeadingRow,
SkipsOnError,
WithValidation,
SkipsOnFailure

{
    use Importable,SkipsErrors, SkipsFailures;
    public $type; 
    public $rowCount;
    public $rowLimit; 
    
    public function __construct($type,$rowLimit)
    {
        $this->type = $type;
        $this->rowCount = 0;
        $this->rowLimit = $rowLimit;
    }

    public function model(array $row)
    {
        if ($this->rowCount >= $this->rowLimit) {
            return null; 
        }

        $empId=$row['emp_id'];
        //    dd($empId);
        if($empId!=null){
            $de_type='Emp';
            $prefix = 'ACSEM' ;
        }else{
            $de_type='Dept';
            $prefix = 'ACSDE' ;
        }
        // Generate the date in the 'Ymd' format
        $date = Carbon::today()->format('Ymd');
      
        $today = LaptopAssetCode::where(['date' => Carbon::today()->format('Y-m-d'), 'type' => $de_type])->get();
        // dd($today);
        if ($today->isEmpty()) {
            $suffix = 1;
        } else {
            $next = $today->count();
            $suffix = $next + 1;
        }

        // Format the suffix as a 4-digit string
        $data = sprintf("%'.04d", $suffix);
       
        $doc_no = $prefix. $date . '-' . $data;
        // dd($doc_no);

        $laptop_asset_code=$row['laptop_asset_code'];
        $handset_asset_code=$row['handset_asset_code'];
        if($laptop_asset_code==null){
            $assettype='phone';
        }elseif($handset_asset_code==null){
            $assettype='laptop';
        }else{
            $assettype='lp';
        }
        $branch = Branch::where('branch_code',$row['branch_code'])->first();
        $ex_date = $row['receipt_date'];
        $receipt_date = Date::excelToDateTimeObject($ex_date)->format('Y-m-d');
        // dd($receipt_date);
    
        $new = new LaptopAssetCode();
        $new->doc_no = $doc_no;
        $new->type      = $de_type;
        $new->emp_name  = $row['emp_name'];
        $new->emp_code  = $row['emp_id'];
        $new->branch_code = $row['branch_code'];
        $new->branch_name = $branch->branch_name;
        $new->department  = $row['department'];
        $new->asset_type  = $assettype;
        $new->laptop_asset_code = $laptop_asset_code==null? '':$laptop_asset_code;
        $new->laptop_asset_name = $row['laptop_asset_name'] ==null ?'': $row['laptop_asset_name'];
        $new->handset_asset_code = $row['handset_asset_code']==null? '' : $row['handset_asset_code'];
        $new->handset_asset_name = $row['handset_asset_name']==null? '' : $row['handset_asset_name'];
        $new->sim_name           = $row['operator']==null? '' : $row['operator'];
        $new->sim_phone          = $row['phone_number']==null? '' :$row['phone_number'];    
        $new->receipt_date       = $receipt_date==null? '' : $receipt_date;
        $new->receipt_type       = $row['receipt_type']==null? '' : $row['receipt_type'];
        $new->remark             = $row['remark']==null? '' : $row['remark'];
        $new->date               = Carbon::today()->format('Y-m-d');
        $new->save();
      
        $this->rowCount++;
        return $new;
    }


    public function rules(): array
    {
        return [
            'laptop_asset_code' =>[
            function($attribute,$value,$fail){
                $old_laptop_asset =LaptopAssetCode::where(['laptop_asset_code'=>$value])->latest()->first();

                if($old_laptop_asset){
                    $fail("The :attribute already added.");
                }
   
            }
        ],
        'handset_asset_code' =>[
        function($attribute,$value,$fail){
            $old_phone_assect =LaptopAssetCode::where(['handset_asset_code'=>$value])->latest()->first();

            if($old_phone_assect){
                $fail("The :attribute already added.");
            }

        }
    ],
    'emp_code' =>[
        function($attribute,$value,$fail){
            $old_emp_code =LaptopAssetCode::where(['emp_code'=>$value])->latest()->first();

            if($old_emp_code){
                $fail("The :attribute already added.");
            }

        }
    ]

        ];
    }
}
