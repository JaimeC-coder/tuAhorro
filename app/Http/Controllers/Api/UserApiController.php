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
    public function index( Request $request)
    {
        try {
            $data =  $this->userController->index($request);
            return JsonResponse::success($data, 'Users fetched successfully', true, 1, 200);
        } catch (\Exception $e) {
            return JsonResponse::error($e->getMessage(), 'Error', false, 0, 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {

        try {
            $data =  $this->userController->store($request);
            return JsonResponse::success($data, 'User created successfully', true, 1, 201);
        } catch (\Exception $e) {
            return JsonResponse::error($e->getMessage(), 'Error', false, 0, 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
