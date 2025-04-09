<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    //
    protected $fillable = [
        'user_id',
        'coin_id',
        'amount',
        'name',
        'remainingAmount',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function coin()
    {
        return $this->belongsTo(Coin::class);
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
        return number_format($value, 2);
    }
    public function getRemainingAmountAttribute($value)
    {
        return number_format($value, 2);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = number_format($value, 2);
    }
    public function setRemainingAmountAttribute($value)
    {
        $this->attributes['remainingAmount'] = number_format($value, 2);
    }
 

}
