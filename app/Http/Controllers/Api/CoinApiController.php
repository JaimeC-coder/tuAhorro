<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\CoinController;
use App\Http\Controllers\Controller;
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
      

        try {
            $data = $this->coinController->store($request);
            return JsonResponse::success($data, 'Moneda creada correctamente', true, 1, 201);
        } catch (\Exception $e) {
            return JsonResponse::error($e->getMessage(), 'Error en la API', false, 0, $e->getCode() );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Coin $coin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coin $coin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coin $coin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coin $coin)
    {
        //
    }
}
