<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    public function rules(): array
    {
        return match ($this->method()) {
            'POST' => $this->rulesPost(),
            'PUT' => $this->rulesPut(),
            'DELETE' => $this->rulesDestroy(),
            'PATCH' => $this->rulesPatch(),
            default => $this->rulesGet()
        };
    }

    protected function rulesGet(): array { return []; }
    protected function rulesPost(): array { return []; }
    protected function rulesPut(): array { return []; }
    protected function rulesDestroy(): array { return []; }
    protected function rulesPatch(): array { return []; }



}
