<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\DTOs\UserDTO;
use App\DTOs\UserFilterDTO;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $UserRepository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    /**
     * Get all users
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers(UserFilterDTO $userFilterDTO)
    {
        // Validar el DTO
        if (!$userFilterDTO->hasFilters()) {
            throw new \InvalidArgumentException('Invalid filter parameters');
        }

        // Obtener los usuarios filtrados
        return $this->UserRepository->getUsers($userFilterDTO->toArray());
    }


    public function createUser(UserDTO $userDTO)
    {
        // Encriptar contraseña antes de guardarla
        $userDTO->password = Hash::make($userDTO->password);

        return $this->UserRepository->create((array) $userDTO);
    }
}
