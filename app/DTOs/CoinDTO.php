<?php

namespace App\DTOs;


class  CoinDTO implements InterfaseDTO
{
    private const UNDEFINED = '__UNDEFINED__';


    public function __construct(
        public readonly  mixed  $type = self::UNDEFINED,
        public readonly  mixed  $symbol = self::UNDEFINED,
        public readonly  ?int  $id = null

    ) {}

    public static function fromArrayAPI(array $data): self
    {
        return new self(
            id: $data['id']           ?? null,
            type: array_key_exists('type', $data)       ? $data['type']       : self::UNDEFINED,
            symbol: array_key_exists('symbol', $data)       ? $data['symbol']       : self::UNDEFINED,

        );
    }
    public static function fromArraywEB(array $data): self
    {
        return new self(
            id: $data['id']           ?? null,
            type: array_key_exists('type', $data)       ? $data['type']       : self::UNDEFINED,
            symbol: array_key_exists('symbol', $data)       ? $data['symbol']       : self::UNDEFINED,

        );
    }


    public function has(string $field): bool
    {
        return $this->$field !== self::UNDEFINED;
    }

    public function toArray(): array
    {
        $fields = ['type', 'symbol'];
        $result = [];

        foreach ($fields as $field) {
            if ($this->has($field)) {
                $result[$field] = $this->$field;
            }
        }

        return $result;
    }
}
