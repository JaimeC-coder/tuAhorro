<?php

namespace App\Repositories;

use App\Models\Loans;

class LoansRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Loans());
    }
}