<?php

namespace App\DTOs;

use App\Http\Requests\UserRequest;

class UserDTO
{
    public string $name;
    public string $email;
    public string $phone;
    public string $password;
    public ?string $id;
    public function __construct(string $name, string $phone, string $email, string $password , ?string $id = null)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->password = $password;
        $this->id = $id;
    }

    public static function fromRequest(UserRequest $request): self
    {
        return new self(
            $request['name'],
            $request['phone'],
            $request['email'],
            $request['password'],
            $request->input('id')
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'id' => $this->id

        ];
    }

}
