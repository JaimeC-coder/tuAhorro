<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    //
    protected $fillable = [
        'type',
        'symbol',
    ];

    public function savings()
    {
        return $this->hasMany(Saving::class);
    }
    public function getTypeAttribute($value)
    {
        return ucfirst($value);
    }
    public function getSymbolAttribute($value)
    {
        return strtoupper($value);
    }
    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = strtolower($value);
    }
    public function setSymbolAttribute($value)
    {
        $this->attributes['symbol'] = strtoupper($value);
    }
    public function getRouteKeyName()
    {
        return 'symbol';
    }
    public function getRouteKey()
    {
        return $this->getRouteKeyName();
    }
    public function getRouteKeyValue()
    {
        return $this->getRouteKey();
    }
 



}
