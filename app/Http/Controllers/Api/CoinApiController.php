<?php

namespace App\Http\Controllers\Api;

use App\DTOs\CoinDTO;
use App\DTOs\Filter\CoinFilterDTO;
use App\Helpers\ResourceViewHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CoinRequest;
use App\Http\Resources\CoinResource;
use App\Services\CoinService;
use Illuminate\Http\Request;
use App\Traits\ApiResponder;


class CoinApiController extends Controller
{
    use ApiResponder;

    protected CoinService $coinService;

    public function __construct(CoinService $coinService)
    {
        $this->coinService = $coinService;
    }

    public function listar(Request $request)
    {

        return $this->handleApiRequest(function () use ($request) {
            if ($request->has('id')) {
                $loans = $this->coinService->find(CoinDTO::fromArrayAPI($request->validated())->id);
                $loans = new CoinResource($loans);
                return $loans;
            }
            $loans = $this->coinService->getAllCoins(CoinFilterDTO::fromRequest($request));
            $loans = CoinResource::collection($loans);
            return  ResourceViewHelper::paginate($loans, $request);
        }, 'Monedas obtenidas correctamente');
    }

    public function register(CoinRequest $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            return $this->coinService->create(CoinDTO::fromArrayAPI($request->validated()));
        }, 'Moneda creada correctamente', 201);
    }

    public function actualizar(CoinRequest $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            return $this->coinService->update($request->id, CoinDTO::fromArrayAPI($request->validated()));
        }, 'Moneda actualizada correctamente');
    }

    public function eliminar(CoinRequest $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            return $this->coinService->delete($request->id);
        }, 'Moneda eliminada correctamente');
    }
}
