<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class LoanRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rulesForCambiarEstado(): array
    {
        return $this->rulesPatchStatus();
    }

    public function rulesGet(): array
    {
        return [
            'page'      => 'nullable|integer|min:1',
            'limit'     => 'nullable|integer|min:1|max:100',
            'sort'      => 'nullable|string|in:id,created_at',
            'direction' => 'nullable|string|in:asc,desc',
        ];
    }

    public function rulesShow(): array
    {
        return [
            'id' => 'string|max:255',
            'page' => 'integer|min:1',
            'limit' => 'integer|min:1|max:100',
        ];
    }
    public function rulesPost(): array
    {

        return [
            'person' => 'required|string|max:255',
            'amount' => 'nullable|required_if:type_loans,cuota|numeric|min:0',
            'type_loans' => 'required|in:prestamo,cuota',
            'number_loans_cuota' =>  'nullable|required_if:type_loans,cuota|numeric|min:0',
            'type_loans_cuota' =>   'nullable|required_if:type_loans,cuota|in:mensual,semanal',

            'loan_details' =>  'required_if:type_loans,prestamo|array',
            'loan_details.*.amount' =>  'required_if:type_loans,prestamo|numeric',
            'loan_details.*.type' =>  'required_if:type_loans,prestamo|in:adelanto,prestamo,cuota',
            'loan_details.*.date' =>  'nullable|date',
            'loan_details.*.description' =>  'required_if:type_loans,prestamo|string|max:255',
            //'loan_details.*.status' =>  'required_if:type_loans,prestamo|in:pendiente,pagado',
        ];
    }

    public function rulesPut(): array
    {
        return [
            'id' => 'required|int|max:255',
            'person' => 'required|string|max:255',
            'amount' => 'nullable|numeric|min:0',
        ];
    }

    public function rulesPatch(): array
    {
        return [
            'id' => 'required|int|max:255',
            'person' => 'string|max:255',
            'loan_details' => 'array',
            'loan_details*.amount' => 'numeric|min:0',
            'loan_details*.type' => 'in:adelanto,prestamo,cuota',
            'loan_details*.date' => 'date',
            'loan_details*.description' => 'string|max:255',
            'loan_details*.status' => 'in:pendiente,pagado',
        ];
    }
    public function rulesPatchStatus(): array
    {
        return [
            'id' => 'required|int|max:255',
            'loan_details_id' => 'required|int|max:255',
            'person' => 'string|max:255',
            'loan_details_status' => 'in:pendiente,pagado',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'El campo id es obligatorio.',
            'id.integer' => 'El campo id debe ser un número entero.',
            'id.max' => 'El campo id no debe exceder los 255 caracteres.',
            'person.required' => 'El campo persona es obligatorio.',
            'amount.required' => 'El campo monto es obligatorio.',
            'amount.numeric' => 'El campo monto debe ser un número.',
            'amount.min' => 'El campo monto debe ser un número positivo.',
            'type_loans.required' => 'El campo tipo de préstamo es obligatorio.',
            'type_loans.in' => 'El campo tipo de préstamo debe ser prestamo o cuota.',
            // //----------------------------------
            'number_loans_cuota.required' => 'El campo número de cuotas es obligatorio.',
            'type_loans_cuota.required' => 'El campo tipo de cuota es obligatorio.',

            'number_loans_cuota.required_if' => 'El campo número de cuotas es obligatorio cuando el tipo de préstamo es cuota.',
            'type_loans_cuota.required_if' => 'El campo tipo de cuota es obligatorio cuando el tipo de préstamo es cuota.',
            // //----------------------------------
            'loan_details.required_if' => 'El campo detalles de préstamo es obligatorio cuando el tipo de préstamo es prestamo.',
            'loan_details.required' => 'Debe agregar al menos un detalle de préstamo.',
            'loan_details.*.amount.required' => 'El campo monto en los detalles de préstamo es obligatorio.',
            'loan_details.*.amount.numeric' => 'El campo monto en los detalles de préstamo debe ser un número.',
            'loan_details.*.date.required' => 'El campo fecha en los detalles de préstamo es obligatorio.',
            'loan_details.*.type.required' => 'El campo tipo en los detalles de préstamo es obligatorio.',
        ];
    }
}
