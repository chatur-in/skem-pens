<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkemSubmission extends Model
{
    protected $fillable = [
        'registration_number',
        'student_id',
        'component',
        'activity_name',
        'role',
        'points',
        'status',
        'admin_note',
        'activity_date'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(SubmissionAttachment::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(SubmissionLog::class)->orderBy('created_at', 'desc');
    }
}