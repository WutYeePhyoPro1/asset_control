<?php

namespace Database\Seeders;

use App\Models\NonRemark;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SyncNonRemarkSubDepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $employees = DB::connection('Hremployee')
            ->table('hremployee.all_employee')
            ->select('employeecode as emp_id', 'employeename as name', 'sub_department', 'section')
            ->whereNotNull('employeecode')
            ->get();

        $updated = 0;

        foreach ($employees as $employee) {
            $subDepartment = $employee->section !== 'Infrastructure' ? $employee->section : $employee->sub_department;

            // emp_id ကိုက်တဲ့ row
            $updated += NonRemark::where('emp_id', $employee->emp_id)
                ->update([
                    'sub_department' => $subDepartment,
                    'updated_at' => now(),
                ]);
        }

        if ($this->command) {
            $this->command->info(
                "HR employee sync complete. Updated NonRemark rows: {$updated}."
            );
        }
    }
}
