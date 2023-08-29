<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{

    protected $fillable = [
        'city',
        'address',
        'phone_number',
        'service',
        'image',
        'curriculum'
    ];

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

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function votes(): BelongsToMany
    {

        return $this->belongsToMany(Vote::class);
    }




    use HasFactory;
}
