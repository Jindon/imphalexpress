<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Package extends Model
{
    use HasFactory;

    const STATUSES = [
        'processing' => 'Processing',
        'received' => 'Received',
        'dispatched' => 'Dispatched',
        'delivered' => 'Delivered',
        'delayed' => 'Delayed',
    ];

    const STATUS_COLORS =[
        'processing' => 'gray',
        'received' => 'orange',
        'dispatched' => 'indigo',
        'delivered' => 'green',
        'delayed' => 'red',
    ];

    protected $guarded = [];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function formatDate($date)
    {
        return Carbon::make($date)->format('d/m/Y');
    }
}
