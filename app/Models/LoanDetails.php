<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanDetails extends Model
{


    protected $table = 'loan_details';

    protected $fillable = [
        'loan_id',
        'amount',
        'type',
        'date',
        'description',
        'status'
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }


}
