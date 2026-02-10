<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerJob extends Model
{
    protected $fillable = [
        'customer_id',
        'pickup',
        'dropoff',
        'vehicle_type',
        'notes',
        'status',
    ];

    public function quotes() {
        return $this->hasMany(Quote::class, 'job_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
