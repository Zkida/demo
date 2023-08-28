<?php

namespace App\Models\Applications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    public function paymentPlan(): BelongsTo
    {
        return $this->belongsTo(PaymentPlan::class);
    }
}
