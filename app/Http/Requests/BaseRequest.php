<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->isMethod('GET') && $this->route()?->hasParameters()) {
            return $this->rulesShow();
        }

        return match ($this->method()) {
            'POST' => $this->rulesPost(),
            'PUT' => $this->rulesPut(),
            'DELETE' => $this->rulesDestroy(),
            'PATCH' => $this->rulesPatch(),
            default => $this->rulesGet()
        };
    }
    public function rulesForAction($action): array
    {
        return match (strtoupper($action)) {
            'POST'   => $this->rulesPost(),
            'PUT'    => $this->rulesPut(),
            'PATCH'  => $this->rulesPatch(),
            'DELETE' => $this->rulesDestroy(),
            'SHOW'   => $this->rulesShow(),
            default  => $this->rulesGet(),
        };
    }

    protected function rulesGet(): array
    {
        return [];
    }
    protected function rulesShow(): array
    {
        return [];
    }
    protected function rulesPost(): array
    {
        return [];
    }
    protected function rulesPut(): array
    {
        return [];
    }
    protected function rulesDestroy(): array
    {
        return [];
    }
    protected function rulesPatch(): array
    {
        return [];
    }
}
