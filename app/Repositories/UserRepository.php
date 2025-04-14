<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{


    public function __construct()
    {
        $this->model = new User();
    }

    public function getUserByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
    public function getUserByPhone(string $phone)
    {
        return User::where('phone', $phone)->first();
    }

}
