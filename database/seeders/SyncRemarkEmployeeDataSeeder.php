<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Remark;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SyncRemarkEmployeeDataSeeder extends Seeder
{
    public function run(): void
    {
        $employees = DB::connection('Hremployee')
            ->table('hremployee.all_employee')
            ->select('employeecode as emp_id', 'brchcode as branch_code', 'department', 'sub_department')
            ->whereNotNull('employeecode')
            ->get();

        $matched = 0;
        $updated = 0;

        foreach ($employees as $employee) {
            $branchName = Branch::where('branch_code', $employee->branch_code)
                ->value('branch_name');

            $changes = [
                'branch_code' => $employee->branch_code,
                'branch_name' => $branchName,
                'department' => $employee->department,
                'sub_department' => $employee->section !== 'Infrastructure' ? $employee->section : $employee->sub_department,
                'updated_at' => now(),
            ];

            $rows = Remark::where('emp_id', $employee->emp_id)->update($changes);

            if ($rows > 0) {
                $matched += $rows;
                $updated += $rows;
            }
        }

        if ($this->command) {
            $this->command->info(
                "HR employee sync complete. Matched: {$matched}, updated: {$updated}."
            );
        }
    }
}
