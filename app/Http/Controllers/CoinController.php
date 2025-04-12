<?php

namespace App\Http\Controllers;

use App\DTOs\CoinDTO;
use App\Http\Requests\CoinRequest;
use App\Http\Resources\CoinResource;
use App\Models\Coin;
use App\Services\CoinService;
use Illuminate\Http\Request;

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
        try {
            $request = UserFilterDTO::fromRequest($request);
            $users = $this->userService->getAllUsers($request);
            return UserResource::collection($users);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['error' => 'Unable to fetch users'], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request = CoinRequest::createFrom($request);
        $coinDTO = CoinDTO::fromRequest($request);
        $coin = $this->coinService->create($coinDTO);
        return new CoinResource($coin);

    }

    /**
     * Display the specified resource.
     */
    public function show(Coin $coin)
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
