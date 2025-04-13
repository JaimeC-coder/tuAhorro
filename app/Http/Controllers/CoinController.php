<?php

namespace App\Http\Controllers;

use App\DTOs\CoinDTO;
use App\DTOs\Filter\CoinFilterDTO;
use App\Http\Requests\CoinRequest;
use App\Http\Resources\CoinResource;
use App\Http\Response\ApiValidationException;
use App\Http\Response\JsonResponse;
use App\Models\Coin;
use App\Services\CoinService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CoinController extends Controller
{

    protected $coinService;

    public function __construct(CoinService $coinService)
    {
        $this->coinService = $coinService;
    }



    /**
     * Display a listing of the resource.
     */
    public function list(Request $request)
    {
        $request = CoinRequest::createFrom($request);
        $coinDTO = CoinFilterDTO::fromRequest($request);
        $coins = $this->coinService->getAllCoins($coinDTO);
        return CoinResource::collection($coins);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request = CoinRequest::createFrom($request);
        $validator = Validator::make($request->all(), (new CoinRequest())->rules());

        if ($validator->fails()) {

            throw new ApiValidationException($validator->errors()->toArray());
        }
        $coinDTO = CoinDTO::fromRequest($request);
        $coin = $this->coinService->create($coinDTO);
        return new CoinResource($coin);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $coin)
    {
        //
        $coin = $this->coinService->find($coin->id);
        if (!$coin) {
            throw new \Exception('Moneda no encontrada', 404);

        }
        return new CoinResource($coin);
    }


    public function update(Request $request )
    {
        //
        $request = CoinRequest::createFrom($request);
        $coinDTO = CoinDTO::fromRequest($request);
        $coin = $this->coinService->update($request->id, $coinDTO);
        if (!$coin) {
            throw new \Exception('Moneda no encontrada', 404);

        }
        return new CoinResource($coin);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $request = CoinRequest::createFrom($request);
        $validator = Validator::make($request->all(), (new CoinRequest())->rules());
        if ($validator->fails()) {
            throw new ApiValidationException($validator->errors()->toArray());
        }
        $coin = $this->coinService->delete($request->id);
        if (!$coin) {
            throw new \Exception('Moneda no encontrada', 404);
        }
        return "Moneda eliminada correctamente";
    }
}
