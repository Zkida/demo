<?php

namespace App\Models;

use App\Models\Applications\Application;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Applicant extends Model
{
    use HasFactory;

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    // Returns the full name of the applicant
    public function getFullNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }
}
