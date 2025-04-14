<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsUserAuth;
use App\Http\Resources\UserResource;
use App\Http\Response\JsonResponse;
use App\Traits\ApiResponder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ApiController extends Controller
{

    use ApiResponder;
    protected UserController $userController;

    public function __construct(UserController $userController)
    {
        $this->userController = $userController;
    }

    public function register(Request $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            return $this->userController->store($request);
        }, 'Nuevo usuario creada correctamente', 201);
    }

    //! tenemos que pasarlo a repository
    public function login(Request $request)
    {
        // Logic for user login
        return $this->handleApiRequest(function () use ($request) {
            // Validate the request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            // Attempt to authenticate the user
            if (!$token = JWTAuth::attempt($request->only('email', 'password'))) {
                throw new UnauthorizedHttpException('', 'Credenciales incorrectas', null, 401);
            }

            // Return the token
            return  ['token' => $token];

        }, 'Usuario logueado correctamente');
    }

    public function logout(Request $request)
    {
        // Logic for user logout
        return $this->handleApiRequest(function () use ($request) {
            JWTAuth::invalidate(JWTAuth::getToken());
            return [];
        }, 'Usuario deslogueado correctamente');
    }
    public function refresh(Request $request)
    {
        // Logic for refreshing the token
        return $this->handleApiRequest(function () use ($request) {
            $token = JWTAuth::refresh(JWTAuth::getToken());
            return ['token' => $token];
        }, 'Token actualizado correctamente');
    }
    public function authUser(Request $request)
    {
        return $this->handleApiRequest(function () use ($request) {
            $user = Auth::guard('api')->user();
            return new UserResource($user);
        }, 'Usuario encontrado correctamente', 200);
    }

}
