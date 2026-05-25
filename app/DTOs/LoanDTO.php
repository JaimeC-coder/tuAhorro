<?php

namespace App\DTOs;

use Illuminate\Support\Facades\Auth;

class LoanDTO implements InterfaseDTO
{
    private const UNDEFINED = '__UNDEFINED__';

    public function __construct(
        public readonly ?int    $id           = null,
        public readonly mixed   $person       = self::UNDEFINED,
        public readonly mixed   $amount       = self::UNDEFINED,
        public readonly mixed   $type_loans   = self::UNDEFINED,
        public readonly mixed   $date_init    = self::UNDEFINED,
        public readonly mixed   $loan_details = self::UNDEFINED,
        public readonly ?int    $user_id      = null,
    ) {}

    public static function fromArrayAPI(array $data): self
    {
        return new self(
            id: $data['id']           ?? null,
            person: array_key_exists('person', $data)       ? $data['person']       : self::UNDEFINED,
            amount: array_key_exists('amount', $data)       ? number_format((float) $data['amount'], 2, '.', '') : self::UNDEFINED,
            type_loans: array_key_exists('type_loans', $data)   ? $data['type_loans']   : self::UNDEFINED,
            date_init: array_key_exists('date_init', $data)    ? $data['date_init']    : self::UNDEFINED,
            loan_details: array_key_exists('loan_details', $data) ? $data['loan_details'] : self::UNDEFINED,
            user_id: Auth::guard('api')->id(),
        );
    }
    public static function fromArraywEB(array $data): self
    {
        return new self(
            id: $data['id']           ?? null,
            person: array_key_exists('person', $data)       ? $data['person']       : self::UNDEFINED,
            amount: array_key_exists('amount', $data)       ? number_format((float) $data['amount'], 2, '.', '') : self::UNDEFINED,
            type_loans: array_key_exists('type_loans', $data)   ? $data['type_loans']   : self::UNDEFINED,
            date_init: array_key_exists('date_init', $data)    ? $data['date_init']    : self::UNDEFINED,
            loan_details: array_key_exists('loan_details', $data) ? $data['loan_details'] : self::UNDEFINED,
            user_id: Auth::id(),
        );
    }

    public function has(string $field): bool
    {
        return $this->$field !== self::UNDEFINED;
    }

    public function toArray(): array
    {
        $fields = ['person', 'amount', 'type_loans', 'date_init', 'loan_details', 'user_id'];
        $result = [];

        foreach ($fields as $field) {
            if ($this->has($field)) {
                $result[$field] = $this->$field;
            }
        }

        return $result;
    }
}
