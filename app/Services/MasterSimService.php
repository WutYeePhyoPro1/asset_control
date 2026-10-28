<?php

namespace App\Services;

use App\Models\MasterSim;

class MasterSimService
{
    public function markAsUsed(?string $phone): void
    {
        $phone = trim((string) $phone);

        if ($phone === '' || $phone === '09') {
            return;
        }

        MasterSim::query()
            ->where('simcard', $phone)
            ->whereRaw('LOWER(type) = ?', ['available'])
            ->update(['type' => 'used']);
    }

    public function available()
    {
        return MasterSim::query()
            ->whereRaw('LOWER(type) = ?', ['available'])
            ->orderBy('simcard')
            ->get(['simcard', 'type']);
    }
}
