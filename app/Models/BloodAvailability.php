<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodAvailability extends Model
{
    protected $fillable = [
        'hospital_id',
        'blood_type',
        'quantity',
        'status',
    ];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}