<?php

namespace App\DTOs;

use App\Http\Requests\UserRequest;

class UserDTO
{


    public string $name;
    public string $email;
    public string $phone;
    public string $password;

    public function __construct(string $name, string $email, string $password , string $phone)
    {
        $this->phone = $phone;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public static function fromRequest(UserRequest $request): self
    {
        return new self(
            $request->input('name'),
            $request->input('phone'),
            $request->input('email'),
            $request->input('password')
        );
    }
}
