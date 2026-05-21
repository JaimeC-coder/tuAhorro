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


    public function create(array $data): Model
    {
        return $this->transaction(function () use ($data) {
            $loan = parent::create($data);
            if (isset($data['loan_details']) && is_array($data['loan_details'])) {
                foreach ($data['loan_details'] as $detail) {
                    $loan->details()->create([
                        'description' => $detail['description'],
                        'amount' => $detail['amount'],
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
                'amount' => $detail['amount'],
                'type' => $detail['type'],
                'date' => $detail['date'] ?? now()->toDateString(),
            ]);
        }
        //* por el momento  convertimos el valor de  $loan['amount'] a float para sumarle el nuevo monto
        $loanAmount = (float) str_replace(',', '', $loan['amount']);

        $loan['amount'] = $loanAmount + (float) $data['amount'];

        // Lo correcto seria : $loan['amount'] += (float) $data['amount']; pero por alguna razon no funciona el operador de asignacion compuesto
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
