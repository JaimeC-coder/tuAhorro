<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use Filterable;

    protected $table = 'loan';

    protected $fillable = [
        'person',
        'amount',
        'porcent',
        'type_loans',
        'type',
        'user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(LoanDetails::class);
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
    public function getRouteKey()
    {
        return $this->getRouteKeyName();
    }

    public function getRouteKeyValue()
    {
        return $this->getRouteKey();
    }
    public function getAmountAttribute($value)
    {
        $clean = str_replace(',', '', $value);
        return number_format((float) $clean, 2);
    }
    public function getRemainingAmountAttribute($value)
    {
        return number_format($value, 2);
    }

    public function setPersonAttribute($value)
    {
        $this->attributes['person'] = strtolower($value);
    }
    public function getPersonAttribute($value)
    {
        return ucfirst($value);
    }
    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = number_format($value, 2);
    }
    public function setPorcentAttribute($value)
    {
        $this->attributes['porcent'] = number_format($value, 2);
    }
}
