<?php

namespace App\DTOs;

use App\Http\Requests\LoanRequest;
use Illuminate\Support\Facades\Auth;

class LoanDTO
{


    public ?string $id;


    public string $person;
    public string $amount;
    public string $type_loans;
    public array $loan_details = [];
    public string $user_id;
    // public string $date_init;
    // public string $loan_details_description;
    // public string $loan_details_amount;
    // public string $loan_details_type_loans;
    // public string $loan_details_date;
    // public string $number_loans_cuota;
    // public string $type_loans_cuota;




    public function __construct(string $person, string $amount, string $type_loans, ?string $id = null, array $loan_details = [], string $user_id = '')
    {
        $this->person = $person;
        $this->amount = $amount;
        $this->type_loans = $type_loans;
        $this->id = $id;
        $this->user_id = $user_id;
        $this->loan_details = $loan_details;
    }

    public static function fromRequest(LoanRequest $data): self
    {
        return new self(
            $data->input('person'),
            $data->input('amount'),
            $data->input('type_loans'),
            $data->input('id'),
            $data->input('loan_details', [])
        );
    }

    public static function fromLivewire(object $component): self
    {
        return new self(
            person: $component->person,
            amount: $component->amount,
            type_loans: $component->type_loans,
            id: $component->id ?? null,
            loan_details: $component->loan_details,
            user_id: Auth::id()
        );
    }

    public function toArray(): array
    {
        return [
            'person' => $this->person,
            'amount' => $this->amount,
            'type_loans' => $this->type_loans,
            'id' => $this->id,
            'loan_details' => $this->loan_details,
            'user_id' => $this->user_id,
        ];
    }
}
