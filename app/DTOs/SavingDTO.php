<?php

namespace App\DTOs;

use App\Http\Requests\SavingRequest;

class SavingDTO implements InterfaseDTO
{

    private const UNDEFINED = '__UNDEFINED__';
    public function __construct(
        public readonly  mixed  $amount = self::UNDEFINED,
        public readonly  mixed  $coin_id = self::UNDEFINED,
        public readonly  mixed  $user_id = self::UNDEFINED,
        public readonly  mixed  $name = self::UNDEFINED,
        public readonly  mixed  $remainingAmount = self::UNDEFINED,
        public readonly ?int $id = null

    ) {}

    public static function fromArrayAPI(array $data): self
    {
        return new self(
            id: $data['id']           ?? null,
            amount: array_key_exists('amount', $data)       ? $data['amount']       : self::UNDEFINED,
            coin_id: array_key_exists('coin_id', $data)       ? $data['coin_id']       : self::UNDEFINED,
            user_id: array_key_exists('user_id', $data)       ? $data['user_id']       : self::UNDEFINED,
            name: array_key_exists('name', $data)       ? $data['name']       : self::UNDEFINED,
            remainingAmount: array_key_exists('remainingAmount', $data)       ? $data['remainingAmount']       : self::UNDEFINED,

        );
    }
    public static function fromArraywEB(array $data): self
    {
        return new self(
            id: $data['id']           ?? null,
            amount: array_key_exists('amount', $data)       ? $data['amount']       : self::UNDEFINED,
            coin_id: array_key_exists('coin_id', $data)       ? $data['coin_id']       : self::UNDEFINED,
            user_id: array_key_exists('user_id', $data)       ? $data['user_id']       : self::UNDEFINED,
            name: array_key_exists('name', $data)       ? $data['name']       : self::UNDEFINED,
            remainingAmount: array_key_exists('remainingAmount', $data)       ? $data['remainingAmount']       : self::UNDEFINED,

        );
    }

    public function has(string $field): bool
    {
        return $this->$field !== self::UNDEFINED;
    }

    public function toArray(): array
    {
        $fields = ['amount', 'coin_id', 'user_id', 'name', 'remainingAmount'];
        $result = [];

        foreach ($fields as $field) {
            if ($this->has($field)) {
                $result[$field] = $this->$field;
            }
        }

        return $result;
    }
}
