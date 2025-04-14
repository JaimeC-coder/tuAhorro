<?php

namespace App\DTOs\Filter;

use App\Http\Requests\CoinRequest;

class CoinFilterDTO
{
    public ?array $type;
    public ?array $symbol;
    public ?array $created_at;

    public function __construct(?array $type = null, ?array $symbol = null, ?array $created_at = null)
    {
        $this->type = $type;
        $this->symbol = $symbol;
        $this->created_at = $created_at;
    }

    public static function fromRequest(CoinRequest $data): self
    {
        return new self(
            $data->input('type'),
            $data->input('symbol'),
            $data->input('created_at') ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'symbol' => $this->symbol,
            'created_at' => $this->created_at,
        ];
    }
}
