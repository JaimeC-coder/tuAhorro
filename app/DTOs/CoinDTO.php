<?php

namespace App\DTOs;

use App\Http\Requests\CoinRequest;

class CoinDTO
{
    public string $type;
    public string $symbol;
    public ?string $id;

    public function __construct(string $type, string $symbol, ?string $id = null)
    {
        $this->type = $type;
        $this->symbol = $symbol;
        $this->id = $id;
    }

    public static function fromRequest(CoinRequest $data): self
    {
        return new self(
            $data->input('type'),
            $data->input('symbol'),
            $data->input('id')
        );
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'symbol' => $this->symbol,
            'id' => $this->id,
        ];
    }
}
