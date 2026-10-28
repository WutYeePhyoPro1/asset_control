<?php

namespace App\Imports;

use App\Models\MasterSim;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MasterSimImport implements ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    private int $added = 0;

    private int $updated = 0;

    private int $unchanged = 0;

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $this->importRow($row);
        }
    }

    public function prepareForValidation(array $row): array
    {
        $row['simcard'] = $this->cleanSimcard($row['simcard'] ?? null);
        $row['type'] = $this->cleanType($row['type'] ?? null);

        return $row;
    }

    public function summary(): array
    {
        return [
            'added' => $this->added,
            'updated' => $this->updated,
            'unchanged' => $this->unchanged,
            'total' => $this->added + $this->updated + $this->unchanged,
        ];
    }

    public function rules(): array
    {
        return [
            'simcard' => ['required'],
            'type' => ['required', 'in:reserve,available,used'],
        ];
    }

    private function importRow(Collection $row): void
    {
        $simcard = $row['simcard'];
        $type = $row['type'];

        $sim = MasterSim::where('simcard', $simcard)
            ->orWhere('simcard', '"' . $simcard . '"')
            ->first();

        if ($sim === null) {
            MasterSim::create(['simcard' => $simcard, 'type' => $type]);
            $this->added++;

            return;
        }

        if ($this->cleanType($sim->type) === $type) {
            $this->unchanged++;

            return;
        }

        $sim->update(['type' => $type]);
        $this->updated++;
    }

    private function cleanSimcard(mixed $value): string
    {
        return trim((string) $value, " \t\n\r\0\x0B\"'“”‘’");
    }

    private function cleanType(mixed $value): string
    {
        return Str::lower(trim((string) $value));
    }
}
