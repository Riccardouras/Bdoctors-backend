<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Doctor extends Model
{

    // Get the user that owns the Doctor Profile//

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
        return $this->belongsToMany(Specialty::class);
    }




    use HasFactory;
}
