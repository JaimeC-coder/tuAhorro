<?php

namespace App\Http\Requests;



class CoinRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rulesGet(): array
    {
        return [
            'id' => 'string|max:255',
            'type' => 'string|max:255',
            'symbol' => 'string|max:255',
            'page' => 'integer|min:1',
            'limit' => 'integer|min:1|max:100',
        ];
    }
    public function rulesPost(): array
    {
        return [
            'type' => 'required|string|max:255',
            'symbol' => 'required|string|max:255',
        ];
    }

    public function rulesPut(): array
    {
        return [
            'id' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'symbol' => 'required|string|max:255',
        ];
    }
    public function rulesDestroy(): array
    {
        return [
            'id' => 'required|string|max:255',
        ];
    }
    public function rulesPatch(): array
    {
        return [
            'id' => 'required|string|max:255',
            'type' => 'string|max:255',
            'symbol' => 'string|max:255',
        ];
    }
}
