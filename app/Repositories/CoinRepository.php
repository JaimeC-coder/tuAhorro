<?php

namespace App\Repositories;

use App\Models\Coin;
use Illuminate\Support\Facades\Log;

class CoinRepository
{
    public function create(array $data)
    {
        try {
            return Coin::create($data);
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Error de base de datos: ' . $e->getMessage());
            throw $e;
        } catch (\Throwable $th) {
            Log::error('Error inesperado: ' . $th->getMessage());
            throw $th;
        }
    }
}
