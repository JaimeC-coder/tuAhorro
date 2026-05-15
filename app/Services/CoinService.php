<?php

namespace App\Services;

use App\Repositories\CoinRepository;
use App\DTOs\CoinDTO;
use App\DTOs\Filter\CoinFilterDTO;
use App\Traits\ApiResponder;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Log as FacadesLog;

class CoinService
{
    use ApiResponder;

    protected $coinRepository;

    public function __construct(CoinRepository $CoinRepository)
    {
        $this->coinRepository = $CoinRepository;
    }

    public function create(CoinDTO $dto)
    {
        return $this->coinRepository->create($dto->toArray());
    }

    public function getAllCoins(CoinFilterDTO $dto)
    {
        return $this->coinRepository->all($dto);
    }

    public function find(int|string $id)
    {
        return  $this->coinRepository->find($id);
    }

    public function update(int|string $id, CoinDTO $dto)
    {
        return $this->coinRepository->update($id, $dto->toArray());
    }

    public function delete(int|string $id)
    {
        return $this->coinRepository->delete($id);
    }
}
