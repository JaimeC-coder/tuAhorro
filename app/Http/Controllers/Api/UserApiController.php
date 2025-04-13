<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Requests\UserRequest;
use App\Http\Response\JsonResponse;
use Illuminate\Http\Request;

class UserApiController extends Controller
{

    protected UserController $userController;

    public function __construct(UserController $userController)
    {
        $this->userController = $userController;
    }

    /**
     * Display a listing of the resource.
     */
    public function listar(Request $request)
    {
        try {

            $request = UserRequest::createFrom($request);

            if ($request->has('id')) {
                $data = $this->userController->show($request);
            } else {
                $data = $this->userController->list($request);
            }

            return JsonResponse::success($data, 'Usuarios obtenidas correctamente', true, 1, 200);
        } catch (\App\Http\Response\ApiValidationException $e) {
            return JsonResponse::error($e->render(), $e->getMessage(), false, 0, $e->getCode());
        } catch (\Exception $e) {
            return JsonResponse::error($e->getMessage(), 'Error al obtener usuarios', false, 0, 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        try {
            $data = $this->userController->store($request);
            return JsonResponse::success($data, 'Usuario creada correctamente', true, 1, 201);
        } catch (\App\Http\Response\ApiValidationException $e) {
            return JsonResponse::error($e->render(), $e->getMessage(), false, 0, $e->getCode());
        } catch (\Exception $e) {
            return JsonResponse::error($e->getMessage(), 'Error al crear un usuario', false, 0, 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function actualizar(Request $request)
    {
        try {
            $data = $this->userController->update($request);
            return JsonResponse::success($data, 'Usuario actualizada correctamente', true, 1, 200);
        } catch (\App\Http\Response\ApiValidationException $e) {
            return JsonResponse::error($e->render(), $e->getMessage(), false, 0, $e->getCode());
        } catch (\Exception $e) {
            return JsonResponse::error($e->getMessage(), 'Error al actualizar la moneda', false, 0, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function eliminar(Request $request)
    {
        try {
            $data = $this->userController->destroy($request);
            return JsonResponse::success($data, 'Usuario eliminada correctamente', true, 1, 200);
        } catch (\App\Http\Response\ApiValidationException $e) {
            return JsonResponse::error($e->render(), $e->getMessage(), false, 0, $e->getCode());
        } catch (\Exception $e) {
            return JsonResponse::error($e->getMessage(), 'Error al eliminar la moneda', false, 0, 500);
        }

        //
    }
}
