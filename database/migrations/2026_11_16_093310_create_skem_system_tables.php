<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Master: departments
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // 2. Master: study_programs
        Schema::create('study_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->string('name')->unique();
            $table->enum('degree', ['D3', 'D4', 'S2'])->default('D4');
            $table->timestamps();
        });

        // 3. Mahasiswa: students
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('study_program_id')->constrained('study_programs')->cascadeOnDelete();
            $table->string('nrp', 10)->unique();
            $table->string('name');
            $table->decimal('accumulated_points', 5, 2)->default(0.00);
            $table->timestamps();
        });

        // 4. Transaksi utama: skem_submissions
        Schema::create('skem_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number', 20)->unique(); // contoh: SKEM-2026-AB12C
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->tinyInteger('component');                    // 1, 2, atau 3
            $table->string('activity_name');
            $table->string('role');
            $table->decimal('points', 4, 2);
            $table->enum('status', ['diajukan', 'verifikasi', 'validasi', 'acc', 'tolak'])
                  ->default('diajukan');
            $table->text('admin_note')->nullable();
            $table->date('activity_date')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });

        // 5. Lampiran: submission_attachments (formulir PDF & bukti kegiatan)
        Schema::create('submission_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skem_submission_id')->constrained('skem_submissions')->cascadeOnDelete();
            $table->enum('attachment_type', ['formulir_pdf', 'bukti_kegiatan']);
            $table->string('file_path');
            $table->string('original_name');
            $table->integer('file_size_kb');
            $table->timestamps();
        });

        // 6. Audit trail: submission_logs
        Schema::create('submission_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skem_submission_id')->constrained('skem_submissions')->cascadeOnDelete();
            $table->string('status_from')->nullable();
            $table->string('status_to');
            $table->text('note')->nullable();
            $table->string('actor_role')->default('mahasiswa'); // mahasiswa, admin, verifikator, validator
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission_logs');
        Schema::dropIfExists('submission_attachments');
        Schema::dropIfExists('skem_submissions');
        Schema::dropIfExists('students');
        Schema::dropIfExists('study_programs');
        Schema::dropIfExists('departments');
    }
};