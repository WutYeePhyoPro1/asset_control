<?php

namespace App\Imports;

use App\Models\MasterSim;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MasterSimImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function model(array $row): ?MasterSim
    {
        $simcard = $this->cleanSimcard($row['simcard'] ?? null);

        if ($simcard === '') {
            return null;
        }

        $sim = MasterSim::where('simcard', $simcard)
            ->orWhere('simcard', '"' . $simcard . '"')
            ->first();

        if (!$sim) {
            $sim = new MasterSim();
        }

        $sim->simcard = $simcard;
        $sim->type = $this->cleanType($row['type'] ?? null);
        $sim->save();

        return $sim;
    }

    public function rules(): array
    {
        return [
            'simcard' => ['required'],
            'type' => ['required', 'in:Reserve,Available,Used'],
        ];
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
