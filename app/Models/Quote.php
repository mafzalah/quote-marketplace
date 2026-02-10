<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'job_id',
        'provider_id',
        'price',
        'message',
        'status',
    ];

    public function job() {
        return $this->belongsTo(CustomerJob::class);
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}
