<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SavingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'coin_id' => $this->coin_id,
            'amount' => $this->amount,
            'created_at' => Carbon::parse($this->updated_at)->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
