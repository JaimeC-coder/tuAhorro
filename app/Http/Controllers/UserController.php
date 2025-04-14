<?php

namespace App\Http\Controllers;

use App\DTOs\Filter\UserFilterDTO ;
use App\DTOs\UserDTO;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Response\ApiValidationException;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function list(Request $request)
    {

        $request = UserRequest::createFrom($request);
        $UserDTO = UserFilterDTO::fromRequest($request);
        $coins = $this->userService->getAllUsers($UserDTO);
        return UserResource::collection($coins);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request = UserRequest::createFrom($request);
        $validator = Validator::make($request->all(), (new UserRequest())->rules());

        if ($validator->fails()) {

            throw new ApiValidationException($validator->errors()->toArray());
        }
        $UserDTO = UserDTO::fromRequest($request);
        $coin = $this->userService->create($UserDTO);
        return new UserResource($coin);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $coin)
    {
        //
        $coin = $this->userService->find($coin->id);
        if (!$coin) {
            throw new \Exception('Usuario no encontrada', 404);

        }
        return new UserResource($coin);
    }


    public function update(Request $request )
    {
        //
        $request = UserRequest::createFrom($request);
        $UserDTO = UserDTO::fromRequest($request);
        $coin = $this->userService->update($request->id, $UserDTO);
        if (!$coin) {
            throw new \Exception('Usuario no encontrada', 404);

        }
        return new UserResource($coin);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $request = UserRequest::createFrom($request);
        $validator = Validator::make($request->all(), (new UserRequest())->rules());
        if ($validator->fails()) {
            throw new ApiValidationException($validator->errors()->toArray());
        }
        $coin = $this->userService->delete($request->id);
        if (!$coin) {
            throw new \Exception('Usuario no encontrada', 404);
        }
        return "Usuario eliminada correctamente";
    }
}
