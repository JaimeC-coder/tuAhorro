<?php

namespace App\DTOs;

class LoansDTO
{
    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}