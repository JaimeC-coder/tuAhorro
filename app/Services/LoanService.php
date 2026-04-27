<?php

namespace App\Services;

use App\Repositories\LoansRepository;
use App\DTOs\LoansDTO;

class LoansService
{
    protected $LoansRepository;

    public function __construct(LoansRepository $LoansRepository)
    {
        $this->LoansRepository = $LoansRepository;
    }

    public function create(LoansDTO $dto)
    {
        return $this->LoansRepository->create((array) $dto);
    }
}