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

    public function getAllUsers(UserFilterDTO $userDTO)
    {
        return $this->UserRepository->all($userDTO->toArray());
    }


    public function create(UserDTO $userDTO)
    {
        $userDTO->password = Hash::make($userDTO->password);

        return $this->UserRepository->create((array) $userDTO);
    }
    public function find(int|string $id)
    {
        return $this->UserRepository->find($id);
    }

    public function update(int|string $id, UserDTO $userDTO)
    {
        if (isset($userDTO->password)) {
            $userDTO->password = Hash::make($userDTO->password);
        }
        return $this->UserRepository->update($id, (array) $userDTO);
    }
    public function delete(int|string $id)
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
