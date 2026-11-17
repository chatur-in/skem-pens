<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = ['study_program_id', 'nrp', 'name', 'accumulated_points'];

    public function studyProgram(): BelongsTo
    {
        return $this->belongsTo(StudyProgram::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(SkemSubmission::class);
    }

    // Method OOP untuk mengecek kelulusan kredit SKEM (minimal 3.0)
    public function isEligibleForGraduation(): bool
    {
        return $this->accumulated_points >= 3.00;
    }
}