<?php

namespace App\DTOs;

class CoinFilterDTODTO
{
    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}