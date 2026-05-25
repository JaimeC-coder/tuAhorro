<?php

namespace App\DTOs;

use Illuminate\Support\Facades\Auth;

class UserDTO implements InterfaseDTO
{
    private const UNDEFINED = '__UNDEFINED__';

    public function __construct(
        public readonly string $name = self::UNDEFINED,
        public readonly string $phone = self::UNDEFINED,
        public readonly string $email = self::UNDEFINED,
        public string $password = self::UNDEFINED,
        public readonly ?string $id = null
    ) {}

    public static function fromArrayAPI(array $data): self
    {
        return new self(
            name: array_key_exists('name', $data) ? $data['name'] : self::UNDEFINED,
            phone: array_key_exists('phone', $data) ? $data['phone'] : self::UNDEFINED,
            email: array_key_exists('email', $data) ? $data['email'] : self::UNDEFINED,
            password: array_key_exists('password', $data) ? $data['password'] : self::UNDEFINED,
            id: Auth::guard('api')->id()
        );
    }
    public static function fromArrayWeb(array $data): self
    {
        return new self(
            name: array_key_exists('name', $data) ? $data['name'] : self::UNDEFINED,
            phone: array_key_exists('phone', $data) ? $data['phone'] : self::UNDEFINED,
            email: array_key_exists('email', $data) ? $data['email'] : self::UNDEFINED,
            password: array_key_exists('password', $data) ? $data['password'] : self::UNDEFINED,
            id: Auth::id()
        );
    }
    public function has(string $field): bool
    {
        return $this->$field !== self::UNDEFINED;
    }

    public  function toArray(): array
    {
        $fields = ['name', 'phone', 'email', 'password', 'id'];
        $result = [];

        foreach ($fields as $field) {
            if ($this->has($field)) {
                $result[$field] = $this->$field;
            }
        }

        return $result;
    }
}

