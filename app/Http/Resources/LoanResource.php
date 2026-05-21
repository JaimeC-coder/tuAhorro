<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
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
            'person' => $this->person,
            'amount' => $this->amount,
            'type_loans' => $this->type_loans,
            'loan_details' =>
                $this->details->map(function ($detail) {
                    return [
                        'id' => $detail->id,
                        'amount' => $detail->amount,
                        'type' => $detail->type,
                        'date' => $detail->date,
                        'description' => $detail->description,
                    ];
                }),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
