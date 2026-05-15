<?php

namespace App\Livewire\Loans;

use App\DTOs\LoanDTO;
use App\Http\Requests\LoanRequest;
use App\Services\LoanService;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Create extends Component
{

    public $person;
    public $amount;
    public $type_loans;
    public $loan_details = [];
    public $date_init;
    public $loan_details_description;
    public $loan_details_amount;
    public $loan_details_type_loans;
    public $loan_details_date;
    public $number_loans_cuota;
    public $type_loans_cuota;


    public function mount()
    {
        $this->date_init = now()->toDateString();
    }


    public function addLoanDetail()
    {
        $this->loan_details[] = [
            'description' => $this->loan_details_description,
            'amount' => $this->loan_details_amount,
            'type' => $this->loan_details_type_loans,
            'date' => $this->loan_details_date ?? now()->toDateString(),
        ];

        // dd($this);
        // Reset the input fields
        $this->loan_details_description = '';
        $this->loan_details_amount = '';
        $this->loan_details_type_loans = '';
        $this->loan_details_date = '';
    }

    public function removeLoanDetail($index)
    {
        unset($this->loan_details[$index]);
        $this->loan_details = array_values($this->loan_details); // Reindex the array
    }

    public function save(LoanService $service)
    {
        try {
            $request = new LoanRequest();


            $this->validate(
                // $request->rulesForAction('POST'),, //opcion que se puede usar es esta
                $request->rulesPost(),
                $request->messages()
            );


            if ($this->type_loans == 'cuota') {
                $arrayCuotas = $this->saveCuote($this->number_loans_cuota, $this->amount, $this->type_loans_cuota, $this->date_init);
                $this->loan_details = array_merge($this->loan_details, $arrayCuotas);
            } elseif ($this->type_loans == 'prestamo') {
                $this->amount = $this->savePrestamo($this->loan_details);
            }

            $loanDto = LoanDTO::fromLivewire($this);
            Log::info('LoanDTO creado: ', $loanDto->toArray());
            $loans = $service->create($loanDto);


            session()->flash('message', 'Préstamo creado exitosamente.');
            return redirect()->route('loans.index');
        } catch (ValidationException $e) {
            Log::info('Errores de validación: ', $e->errors());
            throw $e; // ← importante relanzarlo para que Livewire maneje los errores en el blade
        }
    }

    protected function saveCuote($number_loans_cuota, $amount, $type_loans_cuota, $date_init)
    {
        //agregar el valor del prestamo a mi Loan

        $arrayCuotas = [];
        $porcentage = 10;

        if ($number_loans_cuota > 1 && $amount > 100) {
            $porcentage = 20;
        }
        $amount = $amount + ($amount * $porcentage / 100);
        $cuotaAmount = $amount / $number_loans_cuota;

        $cuotaAmount = round($cuotaAmount, 2);

        foreach (range(1, $number_loans_cuota) as $index) {

            if ($type_loans_cuota === 'semanal') {
                $cuotaDate = \Carbon\Carbon::parse($date_init)->addWeeks($index - 1)->toDateString();
            } elseif ($type_loans_cuota === 'mensual') {
                $cuotaDate = \Carbon\Carbon::parse($date_init)->addMonths($index - 1)->toDateString();
            }
            $cuota = [
                'description' => "Cuota {$index}",
                'amount' => $cuotaAmount,
                'type' => 'cuota',
                'date' => $cuotaDate,
            ];

            $arrayCuotas[] = $cuota;
        }
        return $arrayCuotas;
    }

    public function savePrestamo($loan_details)
    {
        $totalAmount = 0;
        foreach ($loan_details as $detail) {

            if ($detail['type'] == 'prestamo') {
                $totalAmount += $detail['amount'];
            } elseif ($detail['type'] == 'adelanto') {
                $totalAmount -= $detail['amount'];
            } else {
                $totalAmount += 0;
            }
        }
        return $totalAmount;
    }


    public function render()
    {
        return view('livewire.loans.create');
    }
}
