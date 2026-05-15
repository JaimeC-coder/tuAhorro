<?php

namespace App\DTOs\Filter;

use Illuminate\Http\Request;

interface FilterDTOInterfaseDTO
{
    public function getRequest(): Request;
    public static function getAllowedFilters(): array;

    // ✅ Agrega los métodos que todos los FilterDTOs deben cumplir
    public function getLimit(): int;
    public function getSort(): string;
    public function getDirection(): string;
    public function hasFilters(): bool;
}
