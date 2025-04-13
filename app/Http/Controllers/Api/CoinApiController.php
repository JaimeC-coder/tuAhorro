<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\CoinController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CoinRequest;
use App\Http\Response\JsonResponse;
use App\Models\Coin;
use Illuminate\Http\Request;

class CoinApiController extends Controller
{
    protected CoinController $coinController;

    public function __construct(CoinController $coinController)
    {
        $this->coinController = $coinController;
    }


    /**
     * Display a listing of the resource.
     */
    public function listar(Request $request)
    {
        try {

            $request = CoinRequest::createFrom($request);

            if($request->has('id')) {
                $data = $this->coinController->show($request);
            }
            else {
                $data = $this->coinController->list($request);
            }

            return JsonResponse::success($data, 'Monedas obtenidas correctamente', true, 1, 200);
        } catch(\App\Http\Response\ApiValidationException $e) {
            return JsonResponse::error($e->render(), $e->getMessage(), false, 0, $e->getCode());
        } catch(\Exception $e) {
            return JsonResponse::error($e->getMessage(), 'Error al obtener las monedas', false, 0, 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        try {
            $data = $this->coinController->store($request);
            return JsonResponse::success($data, 'Moneda creada correctamente', true, 1, 201);
        }  catch(\App\Http\Response\ApiValidationException $e) {
            return JsonResponse::error($e->render(), $e->getMessage(), false, 0, $e->getCode());
        } catch(\Exception $e) {
            return JsonResponse::error($e->getMessage(), 'Error al crear la moneda', false, 0, 500);
        }

    }


    /**
     * Update the specified resource in storage.
     */
    public function actualizar(Request $request)
    {
        try {
            $data = $this->coinController->update($request);
            return JsonResponse::success($data, 'Moneda actualizada correctamente', true, 1, 200);
        } catch(\App\Http\Response\ApiValidationException $e) {
            return JsonResponse::error($e->render(), $e->getMessage(), false, 0, $e->getCode());
        } catch(\Exception $e) {
            return JsonResponse::error($e->getMessage(), 'Error al actualizar la moneda', false, 0, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function eliminar(Request $request)
    {
        try {
            $data = $this->coinController->destroy($request);
            return JsonResponse::success($data, 'Moneda eliminada correctamente', true, 1, 200);
        } catch(\App\Http\Response\ApiValidationException $e) {
            return JsonResponse::error($e->render(), $e->getMessage(), false, 0, $e->getCode());
        } catch(\Exception $e) {
            return JsonResponse::error($e->getMessage(), 'Error al eliminar la moneda', false, 0, 500);
        }

        //
    }
}
