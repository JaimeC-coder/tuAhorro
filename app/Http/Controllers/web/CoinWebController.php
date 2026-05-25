<?php

namespace App\Http\Controllers\web;

use App\DTOs\CoinDTO;
use App\DTOs\Filter\CoinFilterDTO;
use App\Helpers\ResourceViewHelper;

use App\Http\Requests\CoinRequest;
use App\Http\Resources\CoinResource;

use App\Services\CoinService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CoinWebController extends Controller
{
    protected CoinService $coinService;

    public function __construct(CoinService $coinService)
    {
        $this->coinService = $coinService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $coinRequest = CoinRequest::createFrom($request);
        $coinDTO = CoinFilterDTO::fromRequest($coinRequest);
        $coins = $this->coinService->getAllCoins($coinDTO);
        $coins = CoinResource::collection($coins);

       $coins = ResourceViewHelper::paginate($coins, $request);
        return view('web.coins.index', $coins);
    }

    public function create()
    {
        return view('web.coins.create');
    }

    public function edit()
    {
        return view('web.coins.edit');
    }

}
