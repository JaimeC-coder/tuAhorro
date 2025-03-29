<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Get all users
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsers(array $request)
    {
        return User::filter($request)->get();
    }

    public function create(array $data)
    {
        return User::create($data);
    }
}
