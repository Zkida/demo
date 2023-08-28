<?php

namespace App\Models\Applications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentPlan extends Model
{
    use HasFactory;

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
