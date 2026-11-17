<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionLog extends Model
{
    protected $fillable = [
        'skem_submission_id',
        'status_from',
        'status_to',
        'note',
        'actor_role'
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(SkemSubmission::class);
    }
}