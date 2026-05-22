<?php

namespace App\Livewire\Loans;

use App\DTOs\LoanDTO;
use App\Http\Requests\LoanRequest;
use App\Services\LoanService;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Flux\Flux;

class Create extends Component
{

    public ?string $person = null;
    public ?float $amount = null;
    public ?string $type_loans = null;
    public ?string $date_init = null;
    public ?int $number_loans_cuota = null;
    public ?string $type_loans_cuota = null;

    public array $loan_details = [];  // ← solo almacena los detalles guardados

    public array $newDetail = [       // ← solo el formulario temporal
        'description' => '',
        'amount'      => '',
        'type'        => '',
        'date'        => '',
    ];
    // public ?string $loan_details_description = null;
    // public ?float $loan_details_amount = null;
    // public ?string $loan_details_type_loans = null;
    // public ?string $loan_details_date = null;


    public function mount()
    {
        $this->date_init = now()->toDateString();
    }


    public function addLoanDetail()
    {
        try {
            $this->validate([
                'newDetail.description' => 'nullable|string|max:255',
                'newDetail.amount'      => 'required|numeric|min:0.01',
                'newDetail.type'        => 'required|in:prestamo,adelanto',
                'newDetail.date'        => 'nullable|date',
            ], [
                'newDetail.amount.required' => 'El monto es obligatorio.',
                'newDetail.amount.numeric'  => 'El monto debe ser un número.',
                'newDetail.amount.min'      => 'El monto debe ser al menos 0.01.',
                'newDetail.type.required'   => 'El tipo es obligatorio.',
                'newDetail.type.in'         => 'El tipo debe ser "prestamo" o "adelanto".',
            ], [
                'newDetail.description' => 'Descripción',
                'newDetail.amount'      => 'Monto',
                'newDetail.type'        => 'Tipo',
                'newDetail.date'        => 'Fecha',
            ]);

            $this->loan_details[] = [
                'description' => $this->newDetail['description'],
                'amount' => $this->newDetail['amount'],
                'type' => $this->newDetail['type'],
                'date' => $this->newDetail['date'] ?? now()->toDateString(),
            ];

            // Limpiar el formulario temporal
            $this->newDetail = [
                'description' => '',
                'amount'      => '',
                'type'        => '',
                'date'        => '',
            ];
        } catch (ValidationException $e) {
            Log::info('Errores de validación: ', $e->errors());
            throw $e; // ← importante relanzarlo para que Livewire maneje los errores en el blade
        }
    }

    public function removeLoanDetail(int $index)
    {
        unset($this->loan_details[$index]);
        $this->loan_details = array_values($this->loan_details); // Reindex the array
    }

    public function save(LoanService $service)
    {
        try {
            $request = new LoanRequest();
            // $request->rulesForAction('POST'),, //opcion que se puede usar es esta
            $this->validate($request->rulesPost(), $request->messages());
            $details = $this->loan_details;
            $amount = $this->amount;

            if ($this->type_loans == 'cuota') {
                $cuotas = $service->buildCuotas($this->number_loans_cuota, $this->amount, $this->type_loans_cuota, $this->date_init);
                $details = array_merge($details, $cuotas);
            } elseif ($this->type_loans == 'prestamo') {
                $amount = $service->calculatePrestamoAmount($this->loan_details);
            }

            // $loanDto = LoanDTO::fromLivewire($this);

            $loanDto = LoanDTO::fromArraywEB([
                'person'     => $this->person,
                'amount'     => $amount,
                'type_loans' => $this->type_loans,
                'date_init'  => $this->date_init,
                'details'    => $details,
            ]);
            $service->create($loanDto);


            // session()->flash('message', 'Préstamo creado exitosamente.');
            return redirect()->route('loans.index');
        } catch (ValidationException $e) {
            Log::info('Errores de validación: ', $e->errors());
            throw $e; // ← importante relanzarlo para que Livewire maneje los errores en el blade
        }
    }

    public function render()
    {
        return view('livewire.loans.create');
    }
}
