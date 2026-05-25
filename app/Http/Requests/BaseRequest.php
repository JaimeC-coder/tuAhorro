<?php

namespace App\Http\Requests;

use App\Http\Response\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

abstract class BaseRequest extends FormRequest
{
    public function rules(): array
    {

        // Especificaciones para estos casos especificos :
        $action = $this->route()->getActionMethod();
        if (method_exists($this, 'rulesFor' . ucfirst($action))) {
            return $this->{'rulesFor' . ucfirst($action)}();
        }
        //No es necesario implementar esta forma para otros proyectos, pero es una forma de organizar las reglas por acción.


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

    protected function failedValidation(Validator $validator): void
    {

        if ($this->expectsJson()) {
            Log::info('Validation failed', ['errors' => $validator->errors()]);
            JsonResponse::error([
                'errors' => $validator->errors()
            ], "Error de validación", false, 0, 422)->throwResponse();
        }
        parent::failedValidation($validator);

    }
}
