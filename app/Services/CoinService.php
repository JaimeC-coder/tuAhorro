<?php

namespace App\Services;

use App\Repositories\CoinRepository;
use App\DTOs\CoinDTO;
use App\DTOs\Filter\CoinFilterDTO;

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
    public function getAllCoins(CoinFilterDTO $dto)
    {
        try {
            return $this->CoinRepository->all($dto->toArray());
        } catch (\Illuminate\Database\QueryException $e) {
            throw new \Exception('Error en la base de datos: ' . $e->getMessage(), 400);
        } catch (\Throwable $th) {
            throw new \Exception('Error inesperado: ' . $th->getMessage(), 500);
        }
    }
    public function find($id)
    {
        try {
            return $this->CoinRepository->find($id);
        } catch (\Illuminate\Database\QueryException $e) {
            throw new \Exception('Error en la base de datos: ' . $e->getMessage(), 400);
        } catch (\Throwable $th) {
            throw new \Exception('Error inesperado: ' . $th->getMessage(), 500);
        }
    }
    public function update($id, CoinDTO $dto)
    {
        try {
            return $this->CoinRepository->update($id, $dto->toArray());
        } catch (\Illuminate\Database\QueryException $e) {
            throw new \Exception('Error en la base de datos: ' . $e->getMessage(), 400);
        } catch (\Throwable $th) {
            throw new \Exception('Error inesperado: ' . $th->getMessage(), 500);
        }
    }
    public function delete($id)
    {
        try {
            return $this->CoinRepository->delete($id);
        } catch (\Illuminate\Database\QueryException $e) {
            throw new \Exception('Error en la base de datos: ' . $e->getMessage(), 400);
        } catch (\Throwable $th) {
            throw new \Exception('Error inesperado: ' . $th->getMessage(), 500);
        }
    }
}
