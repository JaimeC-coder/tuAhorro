<?php

namespace App\Services;

use App\DTOs\Filter\SavingFilterDTO;
use App\Repositories\SavingRepository;
use App\DTOs\SavingDTO;
use App\Traits\ApiResponder;

class SavingService
{
    use ApiResponder;

    protected SavingRepository $SavingRepository;

    public function __construct(SavingRepository $SavingRepository)
    {
        $this->SavingRepository = $SavingRepository;
    }

    public function create(SavingDTO $dto)
    {
        return $this->SavingRepository->create($dto->toArray());
    }

    public function getAllSavings(SavingFilterDTO $dto)
    {
        return $this->SavingRepository->all($dto);
    }

    public function find(int|string $id)
    {
        return  $this->SavingRepository->find($id);
    }

    public function update(int|string $id, SavingDTO $dto)
    {
        return $this->SavingRepository->update($id, $dto->toArray());
    }

    public function delete(int|string $id)
    {
        return $this->SavingRepository->delete($id);
    }
}
