<?php

namespace App\Services;

use App\Repositories\SavingRepository;
use App\DTOs\SavingDTO;

class SavingService
{
    protected $SavingRepository;

    public function __construct(SavingRepository $SavingRepository)
    {
        $this->SavingRepository = $SavingRepository;
    }

    public function create(SavingDTO $dto)
    {
        return $this->SavingRepository->create((array) $dto);
    }
}