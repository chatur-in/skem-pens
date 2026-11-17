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
        $submissions = SkemSubmission::with(['student.studyProgram.department', 'logs', 'attachments'])->latest()->get();
        
        $stats = [
            'total' => $submissions->count(),
            'proses' => $submissions->whereIn('status', ['diajukan', 'verifikasi', 'validasi'])->count(),
            'acc' => $submissions->where('status', 'acc')->count(),
            'tolak' => $submissions->where('status', 'tolak')->count(),
            'total_poin_acc' => $submissions->where('status', 'acc')->sum('points'),
        ];

        return view('skem.pantau-admin', compact('submissions', 'stats'));
    }

    // Menampilkan dokumen lampiran (formulir / bukti) untuk admin
    public function showAttachment(SubmissionAttachment $attachment)
    {
        abort_unless(Storage::disk('public')->exists($attachment->file_path), 404);

        return response()->file(Storage::disk('public')->path($attachment->file_path));
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