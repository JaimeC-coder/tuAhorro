<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

abstract class BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        try {
            return $this->model->create($data);
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Error de base de datos: ' . $e->getMessage());
            throw new \Exception('Error de base de datos: ' . $e->getMessage(), 400);
        } catch (\Throwable $th) {
            Log::error('Error inesperado: ' . $th->getMessage());
            throw new \Exception('Error inesperado: ' . $th->getMessage(), 500);
        }
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function update($id, array $data)
    {
        $item = $this->model->find($id);
        if (!$item) {
            throw new \Exception('Registro no encontrado', 404);
        }
        $item->update($data);
        return $item;
    }

    public function delete($id)
    {
        $item = $this->model->find($id);
        if (!$item) {
            throw new \Exception('Registro no encontrado', 404);
        }
        $item->delete();
        return true;
    }
}
