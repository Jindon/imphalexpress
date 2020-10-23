<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }

    public function getStatus()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function getCanBeDeletedAttribute()
    {
        return $this->packages->count() > 0;
    }
}
