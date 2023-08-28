<?php

namespace App\Models\Applications;

use App\Models\Applicant;
use App\Models\Certification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    use HasFactory;

    protected $cast = [
        'accepted' => 'boolean',
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function paymentPlan(): HasOne
    {
        return $this->hasOne(PaymentPlan::class);
    }

    public function totalPayments(): float
    {
        return $this->hasOneThrough(Payment::class, PaymentPlan::class)->sum('amount');
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class);
    }
}
