<?php

namespace App\Services\Cases;

use App\Models\CaseRecord;

class CaseLoader
{
    public function load(string $vineId): CaseRecord
    {
        return CaseRecord::query()
            ->with(['casePeople.person.primaryBuilding'])
            ->where('vine_id', $vineId)
            ->firstOrFail();
    }
}
