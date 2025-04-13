<?php

namespace App\DTOs;

use App\Http\Requests\CoinRequest;

class CoinDTO
{
    public ?string $id;
    public string $type;
    public string $symbol;


    public function __construct(string $type, string $symbol , ?string $id = null)
    {
        $this->id = $id;
        $this->type = $type;
        $this->symbol = $symbol;
    }


    public static function fromRequest(CoinRequest $data): self
    {
        return new self(
            $data['type'],
            $data['symbol'],
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
