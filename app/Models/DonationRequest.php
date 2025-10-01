<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hospital_id',
        'notes',
        'status',
    ];

    /**
     * Relationships
     */

    // A donation request belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A donation request belongs to a hospital
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function schedules()
    {
        return $this->hasMany(DonationRequestSchedule::class);
    }
}
