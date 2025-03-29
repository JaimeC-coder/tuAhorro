<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Filterable
{
    /**
     * Aplica filtros dinámicamente al modelo en base a los parámetros de la URL.
     *
     * @param Builder $query
     * @param Request $request
     * @param array $allowedFilters
     * @return Builder
     */
    public function scopeFilter(Builder $query, Request $request, array $allowedFilters = []): Builder
    {
        foreach ($request->all() as $key => $value) {
            // Si el filtro no está permitido, lo ignoramos
            if (!in_array($key, $allowedFilters)) {
                continue;
            }

            // Si el valor es un array, aplicamos WHERE IN
            if (is_array($value)) {
                $query->whereIn($key, $value);
            } else {
                // Si es un solo valor, aplicamos un WHERE normal
                $query->where($key, $value);
            }
        }

        return $query;
    }
}
