<?php

namespace App\Services;

use App\DTOs\Filter\UserFilterDTO;
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

    /**
     * Get all users
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers(UserFilterDTO $userDTO)
    {
        // // Validar el DTO
        // if (!$userFilterDTO->hasFilters()) {
        //     throw new \InvalidArgumentException('Invalid filter parameters');
        // }

        try {
            return $this->UserRepository->all($userDTO->toArray());
        } catch (\Illuminate\Database\QueryException $e) {
            throw new \Exception('Error en la base de datos: ' . $e->getMessage(), 400);
        } catch (\Throwable $th) {
            throw new \Exception('Error inesperado: ' . $th->getMessage(), 500);
        }
    }


    public function create(UserDTO $userDTO)
    {
        // Encriptar contraseña antes de guardarla
        $userDTO->password = Hash::make($userDTO->password);

        return $this->UserRepository->create((array) $userDTO);
    }
    public function find($id)
    {
        return $this->UserRepository->find($id);
    }
    public function update($id, UserDTO $userDTO)
    {
        // Encriptar contraseña antes de guardarla
        if (isset($userDTO->password)) {
            $userDTO->password = Hash::make($userDTO->password);
        }

        return $this->UserRepository->update($id, (array) $userDTO);
    }
    public function delete($id)
    {
        return $this->UserRepository->delete($id);
    }
    public function getUserByEmail($email)
    {
        return $this->UserRepository->getUserByEmail($email);
    }
    public function getUserByPhone($phone)
    {
        return $this->UserRepository->getUserByPhone($phone);
    }
}
