<?php

namespace App\DTOs\Filter;

use App\Http\Requests\LoanRequest;
use App\Http\Requests\SavingRequest;

class SavingFilterDTO implements FilterDTOInterfaseDTO
{

    public ?array $created_at;

    public SavingRequest $request;


    public static array $allowedFilters = ['created_at'];

    public function __construct(SavingRequest $request)
    {
        $this->request  = $request;
        $this->created_at = $request->input('created_at');
    }

    public static function fromRequest(SavingRequest $request): self
    {
        return new self($request);
    }


    public function getRequest(): SavingRequest
    {
        return $this->request;
    }


    public function toArray(): array
    {

        if ($this->created_at === null) {
            return [];
        }

        return [
            'created_at' => $this->created_at,
        ];
    }


    public static function getAllowedFilters(): array
    {
        return ['created_at'];
    }

    public function getLimit(): int
    {
        return (int) $this->request->input('limit', 10);
    }

    public function getSort(): string
    {
        return $this->request->input('sort', 'created_at');
    }

    public function getDirection(): string
    {
        return $this->request->input('direction', 'desc');
    }

    public function hasFilters(): bool
    {
        return !empty(array_filter(
            $this->request->only(self::getAllowedFilters())
        ));
    }
}
