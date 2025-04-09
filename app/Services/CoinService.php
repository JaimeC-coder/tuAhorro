<?php

namespace App\Services;

use App\Repositories\CoinRepository;
use App\DTOs\CoinDTO;

class CoinService
{
    protected $CoinRepository;

    public function __construct(CoinRepository $CoinRepository)
    {
        $this->CoinRepository = $CoinRepository;
    }

    public function create(CoinDTO $dto)
    {
        
        try {
            return $this->CoinRepository->create($dto->toArray());
        } catch (\Illuminate\Database\QueryException $e) {
            throw new \Exception('Error en la base de datos: ' . $e->getMessage(), 400);
        } catch (\Throwable $th) {
            throw new \Exception('Error inesperado: ' . $th->getMessage(), 500);
        }
    }
}
