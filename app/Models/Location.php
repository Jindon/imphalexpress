<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getCanBeDeletedAttribute()
    {
        return $this->businesses->count() > 0 || $this->packages->count() > 0 || $this->users->count() > 0;
    }
}
