<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Doctor extends Model
{

    // Get the user that owns the Doctor Profile//

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
        
    }

    public function specialties(): BelongsToMany
    {
        
        return $this->belongsToMany(Specialty::class);

    }

    public function sponsors(): BelongsToMany
    {
        
        return $this->belongsToMany(Sponsor::class);

    }

    
    public function votes(): BelongsToMany
    {
        
        return $this->belongsToMany(Vote::class);

    }

    use HasFactory;
}
