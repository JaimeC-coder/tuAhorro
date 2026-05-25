<?php

namespace App\Repositories;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Model;

class LoanRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = new Loan();
    }


    public function getInformation(): array
    {


        $basequery = $this->model->where('user_id', auth()->id());


        $totalNegativePrestamo = $basequery->where('amount', '<', 0)->where('type_loans', 'prestamo')->sum('amount');
        $totalPositivoAmountPrestamo = $basequery->where('amount', '>', 0)->where('type_loans', 'prestamo')->sum('amount');
        $totalNegativeCuota = $basequery->where('amount', '<', 0)->where('type_loans', 'cuota')->sum('amount');
        $totalPositivoAmountCuota = $basequery->where('amount', '>', 0)->where('type_loans', 'cuota')->sum('amount');
        $totalAmount = $basequery->sum('amount');

        return [
            'total_negative_amount' => $totalNegativePrestamo,
            'total_positive_amount' => $totalPositivoAmountPrestamo,
            'total_negative_cuota' => $totalNegativeCuota,
            'total_positive_cuota' => $totalPositivoAmountCuota,
            'total_amount' => $totalAmount,
        ];
    }


    public function create(array $data): Model
    {
        return $this->transaction(function () use ($data) {
            $loan = parent::create($data);
            if (isset($data['loan_details']) && is_array($data['loan_details'])) {
                foreach ($data['loan_details'] as $detail) {
                    $loan->details()->create([
                        'description' => $detail['description'],
                        'amount' => (float) str_replace(',', '', $detail['amount']),
                        'type' => $detail['type'],
                        'date' => $detail['date'] ?? now()->toDateString(),
                    ]);
                }
            }
            return $loan;
        });
    }

    public function addDetails(int|string $id, array $data)
    {

        $loan = $this->find($id);
        foreach ($data['loan_details'] as $detail) {
            $loan->details()->create([
                'description' => $detail['description'],
                'amount' => (float) str_replace(',', '', $detail['amount']),
                'type' => $detail['type'],
                'date' => $detail['date'] ?? now()->toDateString(),
            ]);
        }
        //* por el momento  convertimos el valor de  $loan['amount'] a float para sumarle el nuevo monto

        $loan['amount'] += (float) str_replace(',', '', $data['amount']); // pero por alguna razon no funciona el operador de asignacion compuesto
        $loan->save();
        return $loan;
    }

    public function updateStatus(int|string $id, int|string $loanDetailsId, string $status): Model
    {
        $loan = $this->find($id);
        $detail = $loan->details()->find($loanDetailsId);
        if ($detail) {
            $detail->update(['status' => $status]);
        }
        return $loan;
    }

    // private function createDetail(int|string $loanId, array $detail): void
    // {
    //     $loan = $this->find($loanId);
    //     $loan->details()->create([
    //         'description' => $detail['description'],
    //         'amount' => $detail['amount'],
    //         'type' => $detail['type'],
    //         'date' => $detail['date'] ?? now()->toDateString(),
    //     ]);
    // }
}
