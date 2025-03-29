<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\DTOs\UserDTO;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $UserRepository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    public function createUser(UserDTO $userDTO)
    {
        // Encriptar contraseña antes de guardarla
        $userDTO->password = Hash::make($userDTO->password);

        return $this->UserRepository->create((array) $userDTO);
    }
}
