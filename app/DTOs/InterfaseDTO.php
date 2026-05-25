<?php

namespace App\DTOs;


interface InterfaseDTO
{
    public static function fromArrayAPI(array $data): self;
    public static function fromArraywEB(array $data): self;
    public  function toArray(): array;
}
