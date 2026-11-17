<?php

use App\Http\Controllers\SkemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SkemController::class, 'index'])->name('skem.index');
Route::get('/ajukan', [SkemController::class, 'create'])->name('skem.create');
Route::post('/ajukan', [SkemController::class, 'store'])->name('skem.store');
Route::get('/pantau', [SkemController::class, 'track'])->name('skem.track');

// Generator Formulir (halaman HTML mandiri, dibaca langsung dari resources/skem/generator.html)
Route::get('/generator', function () {
    return response(file_get_contents(resource_path('skem/generator.html')), 200, [
        'Content-Type' => 'text/html; charset=utf-8',
    ]);
})->name('skem.generator');

// Route Admin
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [SkemController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::post('/submission/{id}/status', [SkemController::class, 'updateStatus'])->name('admin.status.update');
    Route::get('/berkas/{attachment}', [SkemController::class, 'showAttachment'])->name('skem.berkas');
});