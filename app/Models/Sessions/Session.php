<?php

namespace App\Models\Sessions;

use App\Models\Applicant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Session extends Model
{
    use HasFactory;

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }
}
