<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\StudyProgram;
use App\Models\Student;
use App\Models\SkemSubmission;
use App\Models\SubmissionAttachment;
use App\Services\SkemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkemController extends Controller
{
    protected SkemService $skemService;

    // Dependency Injection (OOP)
    public function __construct(SkemService $skemService)
    {
        $this->skemService = $skemService;
    }

    // Halaman Utama Portal
    public function index()
    {
        return view('skem.index');
    }

    // Halaman Form Pengajuan Mahasiswa
    public function create()
    {
        $studyPrograms = StudyProgram::with('department')->get();
        return view('skem.ajukan', compact('studyPrograms'));
    }

    // Submit Pengajuan Mahasiswa (Menjalankan Transaksi)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nrp' => 'required|numeric|digits:10',
            'study_program_id' => 'required|exists:study_programs,id',
            'component' => 'required|in:1,2,3',
            'activity_name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'points' => 'required|numeric|min:0.01',
            'formulir' => 'required|file|mimes:pdf|max:5120',
            'bukti.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $submission = $this->skemService->createSubmission(
            $request->all(),
            $request->file('formulir'),
            $request->file('bukti') ?? []
        );

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan SKEM berhasil disimpan.',
            'data' => $submission
        ]);
    }

    // Halaman Pantau Status Mahasiswa
    public function track(Request $request)
    {
        $nrp = $request->query('nrp');
        $student = null;
        $submissions = collect();

        if ($nrp) {
            $student = Student::where('nrp', $nrp)->with('studyProgram.department')->first();
            if ($student) {
                $submissions = SkemSubmission::where('student_id', $student->id)
                    ->with(['attachments', 'logs'])
                    ->latest()
                    ->get();
            }
        }

        return view('skem.pantau-mahasiswa', compact('student', 'submissions', 'nrp'));
    }

    // Dashboard Admin
    public function adminDashboard()
    {
        // Hanya kolom yang dipakai view. Kolom foreign key tetap disertakan
        // agar relasi eager loading bisa dipetakan dengan benar.
        // Statistik tidak lagi dihitung di PHP: halaman sudah menghitungnya
        // di sisi klien (renderStats), jadi $stats hanya membuang memori.
        $submissions = SkemSubmission::query()
            ->select([
                'id',
                'registration_number',
                'student_id',
                'component',
                'activity_name',
                'role',
                'points',
                'status',
                'admin_note',
                'created_at',
            ])
            ->with([
                'student:id,study_program_id,nrp,name',
                'student.studyProgram:id,department_id,name',
                'student.studyProgram.department:id,name',
                'attachments:id,skem_submission_id,attachment_type,original_name,file_path',
                'logs:id,skem_submission_id,status_from,status_to,note,created_at',
            ])
            ->latest()
            ->get();

        return view('skem.pantau-admin', compact('submissions'));
    }

    // Menampilkan dokumen lampiran (formulir / bukti) untuk admin
    public function showAttachment(SubmissionAttachment $attachment)
    {
        // Lampiran disimpan di disk private (storage/app/private), tidak bisa diakses via /storage
        abort_unless(Storage::disk('local')->exists($attachment->file_path), 404);

        return response()->file(Storage::disk('local')->path($attachment->file_path));
    }

    // Update Status oleh Admin
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diajukan,verifikasi,validasi,acc,tolak',
            'note' => 'nullable|string'
        ]);

        $this->skemService->updateStatus($id, $request->status, $request->note, 'admin');

        return response()->json(['success' => true, 'message' => 'Status pengajuan berhasil diperbarui.']);
    }
}
