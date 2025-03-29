<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\DTOs\UserDTO;

class UserService
{
    protected $UserRepository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    public function create(UserDTO $dto)
    {
        return $this->UserRepository->create((array) $dto);
    }
}