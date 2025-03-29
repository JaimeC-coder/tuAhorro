<?php

namespace App\DTOs;

use Illuminate\Http\Request;

class UserFilterDTO
{
    public ?array $name;
    public ?array $email;
    public ?array $phone;
    public ?string $created_at;

    public function __construct(?array $name, ?array $email,?array $phone ,?string $created_at = null )
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->created_at = $created_at;
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('name'),
            $request->input('email'),
            $request->input('phone'),
            $request->input('created_at')
        );
    }

    public function hasFilters(): bool
    {
        return !empty($this->name) || !empty($this->email) || !empty($this->created_at) || !empty($this->phone);
    }

    // public function applyFilters($query)
    // {
    //     return $query
    //         ->when($this->name, fn($q) => $q->whereIn('name', $this->name))
    //         ->when($this->email, fn($q) => $q->whereIn('email', $this->email))
    //         ->when($this->phone, fn($q) => $q->whereIn('phone', $this->phone))
    //         ->when($this->created_at, fn($q) => $q->whereDate('created_at', $this->created_at));
    // }



    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at
        ]);
    }
}
