<?php

namespace App\Repositories;

use Closure;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

abstract class BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    protected function handle(Closure $callback)
    {
        try {
            return $callback();
        } catch (QueryException $e) {
            Log::error('Error de base de datos: ' . $e->getMessage());
            throw new Exception('Error de base de datos: ' . $e->getMessage(), 400);
        } catch (\Throwable $th) {
            Log::error('Error inesperado: ' . $th->getMessage());
            throw new Exception('Error inesperado: ' . $th->getMessage(), 500);
        }
    }

    public function create(array $data): Model
    {
        return $this->handle(fn() => $this->model->create($data));
    }

    public function find(int|string $id): ?Model
    {
        return $this->handle(fn() => $this->model->find($id));
    }

    public function all(array $filters = []): \Illuminate\Database\Eloquent\Collection
    {
        return $this->handle(fn() => $this->model->where($filters)->get());
    }

    public function update(int|string $id, array $data): Model
    {
        return $this->handle(function () use ($id, $data) {
            $item = $this->model->find($id);
            if (!$item) {
                throw new Exception('Registro no encontrado', 404);
            }
            $item->update($data);
            return $item;
        });
    }

    public function delete(int|string $id): bool
    {
        return $this->handle(function () use ($id) {
            $item = $this->model->find($id);
            if (!$item) {
                throw new Exception('Registro no encontrado', 404);
            }
            return (bool) $item->delete();
        });
    }
}
