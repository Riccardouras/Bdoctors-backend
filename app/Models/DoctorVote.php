<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DoctorVote extends Pivot
{
    protected $fillable = [
        'date',
        'doctor_id',
        'vote_id',
    ];
}
