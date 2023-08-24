<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{

    // Get the user that owns the Doctor Profile//

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function specializations(): BelongsToMany
    {

        return $this->belongsToMany(Specialization::class);
    }

    public function sponsors(): BelongsToMany
    {

        return $this->belongsToMany(Sponsor::class);
    }




    use HasFactory;
}
