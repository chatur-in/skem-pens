<?php

namespace App\Services;

use App\Models\Student;
use App\Models\SkemSubmission;
use App\Models\SubmissionAttachment;
use App\Models\SubmissionLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SkemService
{
    /**
     * Transaksi pembuatan pengajuan SKEM lengkap dengan lampiran dan audit trail.
     */
    public function createSubmission(array $data, $formulirFile, array $buktiFiles): SkemSubmission
    {
        return DB::transaction(function () use ($data, $formulirFile, $buktiFiles) {
            // 1. Dapatkan atau daftarkan student
            $student = Student::firstOrCreate(
                ['nrp' => $data['nrp']],
                [
                    'name' => $data['name'],
                    'study_program_id' => $data['study_program_id'],
                    'accumulated_points' => 0.00
                ]
            );

            // 2. Generate No Registrasi unik
            $regNo = 'SKEM-' . date('Y') . '-' . strtoupper(Str::random(5));

            // 3. Simpan Transaksi Utama
            $submission = SkemSubmission::create([
                'registration_number' => $regNo,
                'student_id' => $student->id,
                'component' => $data['component'],
                'activity_name' => $data['activity_name'],
                'role' => $data['role'],
                'points' => $data['points'],
                'status' => 'diajukan',
                'activity_date' => $data['activity_date'] ?? now(),
            ]);

            // 4. Simpan Berkas Formulir PDF
            if ($formulirFile) {
                $path = $formulirFile->store('skem/formulir', 'private');
                SubmissionAttachment::create([
                    'skem_submission_id' => $submission->id,
                    'attachment_type' => 'formulir_pdf',
                    'file_path' => $path,
                    'original_name' => $formulirFile->getClientOriginalName(),
                    'file_size_kb' => round($formulirFile->getSize() / 1024),
                ]);
            }

            // 5. Simpan Bukti Kegiatan (Multiple files)
            foreach ($buktiFiles as $bukti) {
                $path = $bukti->store('skem/bukti', 'private');
                SubmissionAttachment::create([
                    'skem_submission_id' => $submission->id,
                    'attachment_type' => 'bukti_kegiatan',
                    'file_path' => $path,
                    'original_name' => $bukti->getClientOriginalName(),
                    'file_size_kb' => round($bukti->getSize() / 1024),
                ]);
            }

            // 6. Simpan Initial Log ke Audit Trail
            SubmissionLog::create([
                'skem_submission_id' => $submission->id,
                'status_from' => null,
                'status_to' => 'diajukan',
                'note' => 'Pengajuan SKEM baru dikirimkan oleh mahasiswa.',
                'actor_role' => 'mahasiswa'
            ]);

            return $submission;
        });
    }

    /**
     * Transaksi perubahan status oleh Verifikator/Validator.
     * Jika status di-ACC, otomatis mengakumulasikan poin ke profile student.
     */
    public function updateStatus(int $submissionId, string $newStatus, ?string $note, string $actorRole = 'admin'): SkemSubmission
    {
        return DB::transaction(function () use ($submissionId, $newStatus, $note, $actorRole) {
            $submission = SkemSubmission::with('student')->findOrFail($submissionId);
            $oldStatus = $submission->status;

            // Update status & catatan
            $submission->update([
                'status' => $newStatus,
                'admin_note' => $note
            ]);

            // Catat ke audit trail log
            SubmissionLog::create([
                'skem_submission_id' => $submission->id,
                'status_from' => $oldStatus,
                'status_to' => $newStatus,
                'note' => $note,
                'actor_role' => $actorRole
            ]);

            // Transaksi bisnis: Jika status disetujui (ACC), tambahkan poin ke akumulasi student
            if ($newStatus === 'acc' && $oldStatus !== 'acc') {
                $student = $submission->student;
                $student->increment('accumulated_points', $submission->points);
            }

            // Jika status dibatalkan dari ACC ke tolak
            if ($oldStatus === 'acc' && $newStatus !== 'acc') {
                $student = $submission->student;
                $student->decrement('accumulated_points', $submission->points);
            }

            return $submission;
        });
    }
}