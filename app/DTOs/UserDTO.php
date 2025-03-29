<?php

namespace App\DTOs;

class UserDTO
{
    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}