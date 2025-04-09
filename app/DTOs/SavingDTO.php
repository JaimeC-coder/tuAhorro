<?php

namespace App\DTOs;

use App\Http\Requests\SavingRequest;

class SavingDTO
{
    public string $amount;
    public string $coin_id;
    public string $user_id;
    public string $name;
    public string $remainingAmount;

    public function __construct(string $amount, string $coin_id, string $user_id, string $name, string $remainingAmount)
    {
        $this->amount = $amount;
        $this->coin_id = $coin_id;
        $this->user_id = $user_id;
        $this->name = $name;
        $this->remainingAmount = $remainingAmount;
    }
    public static function fromRequest(SavingRequest $request): self
    {
        return new self(
            $request->input('amount'),
            $request->input('coin_id'),
            $request->input('user_id'),
            $request->input('name'),
            $request->input('remainingAmount')
        );
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'coin_id' => $this->coin_id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'remainingAmount' => $this->remainingAmount,
        ];
    }
}
