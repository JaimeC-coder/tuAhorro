<?php

namespace App\Services;

use App\DTOs\Filter\LoanFilterDTO;
use App\Repositories\LoanRepository;
use App\DTOs\LoanDTO;

class LoanService
{
    protected $LoansRepository;

    public function __construct(LoanRepository $LoansRepository)
    {
        $this->LoansRepository = $LoansRepository;
    }

    public function create(LoanDTO $dto)
    {
        return $this->LoansRepository->create($dto->toArray());
    }

    public function getAllLoans(LoanFilterDTO $dto)
    {
        return $this->LoansRepository->all($dto);
    }
}
