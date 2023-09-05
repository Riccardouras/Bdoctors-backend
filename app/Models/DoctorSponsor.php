<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DoctorSponsor extends Pivot
{
    protected $fillable = [
        'start_date',
        'end_date',
        'doctor_id',
        'sponsor_id',
    ];
}
