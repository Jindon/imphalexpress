<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPricing extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['charge'];

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (int) $value * 100;
    }

    public function getChargeAttribute()
    {
        return (double) $this->price / 100;
    }

    public function from(){
        return $this->belongsTo(Location::class);
    }

    public function to(){
        return $this->belongsTo(Location::class);
    }
}
