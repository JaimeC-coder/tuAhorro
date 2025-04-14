<?php
namespace App\Repositories;

use App\Models\Coin;

class CoinRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = new Coin();
    }
}
