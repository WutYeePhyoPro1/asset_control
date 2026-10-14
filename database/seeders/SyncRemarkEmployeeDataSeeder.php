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
        $employeeKey = static function ($value): string {
            return strtoupper(trim((string) $value));
        };

        $employees = DB::connection('Hremployee')
            ->table('hremployee.all_employee as emp')
            ->leftJoin('master_data.master_branch as brch', 'brch.branch_code', '=', 'emp.brchcode')
            ->select([
                'emp.employeecode as emp_id',
                'emp.department',
                'emp.sub_department',
                'brch.branch_name',
            ])
            ->whereNotNull('emp.employeecode')
            ->get()
            ->keyBy(fn ($employee) => $employeeKey($employee->emp_id));

        $matched = 0;
        $unmatched = 0;
        $changed = 0;

        DB::transaction(function () use ($employees, $employeeKey, &$matched, &$unmatched, &$changed): void {
            Remark::query()->chunkById(500, function ($remarks) use (
                $employees,
                $employeeKey,
                &$matched,
                &$unmatched,
                &$changed
            ): void {
                foreach ($remarks as $remark) {
                    $employee = $employees->get($employeeKey($remark->emp_id));

                    if (!$employee) {
                        $unmatched++;
                        continue;
                    }

                    $matched++;
                    $branchName = Branch::where('branch_code', $employee->brchcode)->value('branch_name');
                    $updates = [
                        'branch_name' => $branchName,
                        'department' => $employee->department,
                        'sub_department' => $employee->section !== 'Infrastructure' ? $employee->section : $employee->sub_department,
                        'updated_at' => now(),
                    ];

                    if ($remark->branch_name !== $updates['branch_name']
                        || $remark->department !== $updates['department']
                        || $remark->sub_department !== $updates['sub_department']) {
                        $remark->update($updates);
                        $changed++;
                    }
                }
            });
        });

        $message = "HR employee sync complete. Matched: {$matched}, updated: {$changed}, unmatched: {$unmatched}.";

        if ($this->command) {
            $this->command->info($message);
        }
    }
}
