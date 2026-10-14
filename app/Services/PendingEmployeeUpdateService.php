<?php

namespace App\Services;

use App\Models\FixAsset;
use App\Models\Remark;

class PendingEmployeeUpdateService
{
    public function get($monthStart = null, $monthEnd = null)
    {
        $assetsQuery = FixAsset::query()
            ->where(function ($query) {
                $query->whereRaw("LOWER(REPLACE(TRIM(asset_type_name), ' ', '')) = 'handset+simcard'");
            })

            ->where(function ($query) {
                $query->whereNull('status')
                    ->orWhereRaw("LOWER(TRIM(status)) NOT IN ('sold', 'transfered', 'cancel', 's', 't', 'c')");
            });

        if ($monthStart && $monthEnd) {
            $assetsQuery
                ->whereDate('purchase_date', '>=', $monthStart->toDateString())
                ->whereDate('purchase_date', '<', $monthEnd->toDateString());
        }

        // Only Handset+Simcard assets are included in this dashboard count.
        $assets = $assetsQuery->get([
            'asset_code',
            'branch_code',
            'branch_name',
            'asset_type_name',
        ]);

        if ($assets->isEmpty()) {
            return [];
        }

        $latestRemarks = Remark::whereIn('asset_code', $assets->pluck('asset_code'))
            ->latest('updated_at')
            ->latest('id')
            ->get()
            ->unique('asset_code')
            ->keyBy('asset_code');

        return $assets
            ->filter(function ($asset) use ($latestRemarks) {
                $remark = $latestRemarks->get($asset->asset_code);

                return blank($remark?->emp_id) || blank($remark?->emp_name);
            })
            ->groupBy(function ($asset) {
                return $this->branchLabel($asset->branch_name, $asset->branch_code);
            })
            ->map(function ($branchAssets, $branch) {
                return $this->summarize($branch, $branchAssets);
            })
            ->values()
            ->all();
    }

    private function branchLabel($name, $code)
    {
        return trim((string) $name) . '(' . trim((string) $code) . ')';
    }

    private function summarize($branch, $assets)
    {
        $typeCounts = $assets->groupBy(function ($asset) {
            return preg_replace('/\s+/', '', strtolower(trim((string) $asset->asset_type_name)));
        })->map->count();

        return [
            'branch' => $branch,
            'pending_count' => $assets->count(),
            'handset_simcard_count' => $typeCounts->get('handset+simcard', 0),
        ];
    }
}
