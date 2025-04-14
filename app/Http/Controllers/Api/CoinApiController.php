<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\CoinController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CoinRequest;
use Illuminate\Http\Request;
use App\Traits\ApiResponder;


class CoinApiController extends Controller
{

    use ApiResponder;
    protected CoinController $coinController;

    public function __construct(CoinController $coinController)
    {
        $this->coinController = $coinController;
    }

    public function listar(Request $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            $coinRequest = CoinRequest::createFrom($request);

            return $coinRequest->has('id')
                ? $this->coinController->show($coinRequest)
                : $this->coinController->list($coinRequest);
        }, 'Monedas obtenidas correctamente');
    }

    public function register(Request $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            return $this->coinController->store($request);
        }, 'Moneda creada correctamente', 201);
    }

    public function actualizar(Request $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            return $this->coinController->update($request);
        }, 'Moneda actualizada correctamente');
    }

    public function eliminar(Request $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            return $this->coinController->destroy($request);
        }, 'Moneda eliminada correctamente');
    }
}
