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
                        'date' => $detail['date'],
                    ]);
                }
            }

            return $loan;
        });
    }
}
