<?php

namespace App\Http\Controllers\Api;

use App\DTOs\Filter\UserFilterDTO;
use App\DTOs\UserDTO;
use App\Helpers\ResourceViewHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Traits\ApiResponder;

class UserApiController extends Controller
{
    use ApiResponder;
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function listar(UserRequest $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            if ($request->has('id')) {
                $user = $this->userService->find(UserDTO::fromArrayAPI($request->validated())->id);
                $user = new UserResource($user);
                return $user;
            }
            $users = $this->userService->getAllUsers(UserFilterDTO::fromRequest($request));
            $users = UserResource::collection($users);
            return  ResourceViewHelper::paginate($users, $request);
        }, 'Usuarios obtenidos correctamente');


    }

    public function register(UserRequest $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            return $this->userService->create(UserDTO::fromArrayAPI($request->validated()));
        }, 'Usuario creada correctamente', 201);
    }

    public function actualizar(UserRequest $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            return $this->userService->update($request->id, UserDTO::fromArrayAPI($request->validated()));
        }, 'Usuario actualizado correctamente');
    }

    public function eliminar(Request $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            return $this->userService->delete($request->id);
        }, 'Usuario eliminado correctamente');
    }
}
