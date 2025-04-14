<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Requests\UserRequest;
use App\Http\Response\JsonResponse;
use Illuminate\Http\Request;
use App\Traits\ApiResponder;
class UserApiController extends Controller
{
    use ApiResponder;
    protected UserController $userController;

    public function __construct(UserController $userController)
    {
        $this->userController = $userController;
    }

    public function listar(Request $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            $UserRequest = UserRequest::createFrom($request);

            return $UserRequest->has('id')
                ? $this->userController->show($UserRequest)
                : $this->userController->list($UserRequest);
        }, 'Monedas obtenidas correctamente');
    }

    public function register(Request $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            return $this->userController->store($request);
        }, 'Moneda creada correctamente', 201);
    }

    public function actualizar(Request $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            return $this->userController->update($request);
        }, 'Moneda actualizada correctamente');
    }

    public function eliminar(Request $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            return $this->userController->destroy($request);
        }, 'Moneda eliminada correctamente');
    }
}
