<?php

namespace App\Repositories;

use App\Models\Saving;

class SavingRepository
{
    public function create(array $data)
    {
        return Saving::create($data);
    }
}