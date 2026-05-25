<?php

namespace App\Http\Controllers\web;

use App\DTOs\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        // try {
        //     $data =  $this->userService->create($request);
        //     return view('user.create', compact('data'));
        // } catch (\Throwable $th) {
        //     return  $th->getMessage();
        // } catch (\Exception $e) {
        //     return  $e->getMessage();
        // }
    }


}
