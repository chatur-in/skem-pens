<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionAttachment extends Model
{
    protected $fillable = [
        'skem_submission_id',
        'attachment_type',
        'file_path',
        'original_name',
        'file_size_kb'
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(SkemSubmission::class, 'skem_submission_id');
    }
}