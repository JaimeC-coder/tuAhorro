<?php

namespace App\Repositories;

use App\DTOs\Filter\FilterDTOInterfaseDTO;
use Closure;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    protected function transaction(Closure $callback)
    {
        return $this->handle(
            fn() => DB::transaction($callback)
        );
    }
    protected function handle(Closure $callback)
    {
        try {
            return $callback();
        } catch (QueryException $e) {
            Log::error('Error de base de datos: ' . $e->getMessage());
            throw new Exception('Error de base de datos operacion fallida ' , 400);
        } catch (\Throwable $th) {
            Log::error('Error inesperado: ' . $th->getMessage());
            throw new Exception('Error inesperado ', 500);
        }
    }

    public function create(array $data): Model
    {
        return $this->transaction(fn() => $this->model->create($data));
    }

    public function find(int|string $id): ?Model
    {
        return $this->handle(fn() => $this->model->find($id));
    }

    public function all(?FilterDTOInterfaseDTO $dto = null): LengthAwarePaginator
    {
        return $this->handle(function () use ($dto) {
            $query = $this->model->newQuery();

            if ($dto !== null) {
                $query->filter(
                    $dto->getRequest(),
                    $dto::getAllowedFilters()
                );

                return $query
                    ->orderBy($dto->getSort(), $dto->getDirection())
                    ->paginate($dto->getLimit());
            }

            return $query->paginate(15);
        });
    }

    public function update(int|string $id, array $data): Model
    {
        return $this->transaction(function () use ($id, $data) {
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
        return $this->transaction(function () use ($id) {
            $item = $this->model->find($id);
            if (!$item) {
                throw new Exception('Registro no encontrado', 404);
            }
            return (bool) $item->delete();
        });
    }
}
