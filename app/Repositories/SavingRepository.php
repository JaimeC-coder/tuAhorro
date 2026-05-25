<?php

namespace App\Repositories;

use App\Models\Saving;

class SavingRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = new Saving();
    }



}
