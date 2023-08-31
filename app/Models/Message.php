<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{

    protected $fillable = [
        'text',
        'full_name',
        'mail',
        'date',
        'doctor_id'
    ];



    // Get the doctor that owns the message//

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }


    use HasFactory;
}
