<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class EmployeeDirectoryService
{
    public function search(string $term): array
    {
        $searchTerm = '%'.trim($term).'%';

        return DB::connection('Hremployee')
            ->table('hremployee.all_employee as emp')
            ->leftJoin(
                'master_data.master_branch as brch',
                'brch.branch_code',
                '=',
                'emp.brchcode'
            )
            ->select([
                'emp.employeecode as emp_id',
                'emp.employeename as name',
                'emp.positionlevel as rank',
                'emp.department',
                'emp.sub_department',
                'emp.section',
                'emp.brchcode as branch_code',
                'brch.branch_name',
            ])
            ->where(function ($query) use ($searchTerm) {
                $query->where('emp.employeecode', 'ILIKE', $searchTerm)
                    ->orWhere('emp.employeename', 'ILIKE', $searchTerm);
            })
            ->orderBy('emp.employeename')
            ->limit(20)
            ->get()
            ->all();
    }
}
