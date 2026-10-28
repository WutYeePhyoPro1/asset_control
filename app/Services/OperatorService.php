<?php

namespace App\Services;

use App\Models\NonOperator;
use App\Models\Operator;

class OperatorService
{
    public function __construct(private MasterSimService $masterSims) {}

    public function addAssetOperators(array $data): void
    {
        foreach ($data['phones'] as $index => $phone) {
            $phone = $this->normalizePhone($phone);

            Operator::query()->create([
                'asset_code' => $data['asset_code'],
                'department' => $data['department'],
                'branch' => $data['branch'],
                'asset_name' => $data['asset_name'],
                'asset_type' => $data['asset_type'],
                'operator' => $data['operators'][$index] ?? null,
                'phone' => $phone,
            ]);

            $this->masterSims->markAsUsed($phone);
        }
    }

    public function addNonAssetOperators(array $data): void
    {
        foreach ($data['phones'] as $index => $phone) {
            $phone = $this->normalizePhone($phone);

            NonOperator::query()->create([
                'doc_no' => $data['doc_no'],
                'department' => $data['department'],
                'branch' => $data['branch'],
                'operator' => $data['operators'][$index] ?? null,
                'phone' => $phone,
            ]);

            $this->masterSims->markAsUsed($phone);
        }
    }

    public function updateAsset(int|string $id, ?string $operator, ?string $phone): Operator
    {
        $model = Operator::query()->findOrFail($id);
        $model->update([
            'operator' => $operator,
            'phone' => $this->normalizePhone($phone),
        ]);

        $this->masterSims->markAsUsed($model->phone);

        return $model;
    }

    public function updateNonAsset(int|string $id, ?string $operator, ?string $phone): NonOperator
    {
        $model = NonOperator::query()->findOrFail($id);
        $model->update([
            'operator' => $operator,
            'phone' => $this->normalizePhone($phone),
        ]);

        $this->masterSims->markAsUsed($model->phone);

        return $model;
    }

    private function normalizePhone(?string $phone): ?string
    {
        $phone = trim((string) $phone);

        return $phone === '' || $phone === '09' ? null : $phone;
    }
}
