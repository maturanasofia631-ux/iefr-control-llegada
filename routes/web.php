<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ExportController;

Route::get('/', [LandingController::class, 'index']);

Route::get('/admin/student-search', function() {
    return redirect('/admin?' . http_build_query(request()->all()));
})->name('student.search');

// -----------------------------------------------------------------
// EXPORTACIONES — solo Admin y Coordinador
// El middleware 'moonshine.auth' no existe en MoonShine 4.x.
// Verificamos el usuario directamente dentro de cada closure.
// -----------------------------------------------------------------
Route::get('/exports/late-arrivals/excel', function () {
    /** @var \App\Models\MoonshineUser|null $user */
    $user = auth()->guard('moonshine')->user();
    abort_unless($user && ($user->isAdmin() || $user->isCoordinador()), 403);
    return app(ExportController::class)->lateArrivalsExcel();
})->name('exports.late-arrivals.excel');

Route::get('/exports/late-arrivals/pdf', function () {
    /** @var \App\Models\MoonshineUser|null $user */
    $user = auth()->guard('moonshine')->user();
    abort_unless($user && ($user->isAdmin() || $user->isCoordinador()), 403);
    return app(ExportController::class)->lateArrivalsPdf();
})->name('exports.late-arrivals.pdf');

Route::get('/exports/sanctions/excel', function () {
    /** @var \App\Models\MoonshineUser|null $user */
    $user = auth()->guard('moonshine')->user();
    abort_unless($user && ($user->isAdmin() || $user->isCoordinador()), 403);
    return app(ExportController::class)->sanctionsExcel();
})->name('exports.sanctions.excel');

Route::get('/exports/sanctions/pdf', function () {
    /** @var \App\Models\MoonshineUser|null $user */
    $user = auth()->guard('moonshine')->user();
    abort_unless($user && ($user->isAdmin() || $user->isCoordinador()), 403);
    return app(ExportController::class)->sanctionsPdf();
})->name('exports.sanctions.pdf');

Route::get('/exports/student/{id}/excel', function ($id) {
    /** @var \App\Models\MoonshineUser|null $user */
    $user = auth()->guard('moonshine')->user();
    abort_unless($user && ($user->isAdmin() || $user->isCoordinador()), 403);
    return app(ExportController::class)->studentReportExcel($id);
})->name('exports.student.excel');

Route::get('/exports/student/{id}/pdf', function ($id) {
    /** @var \App\Models\MoonshineUser|null $user */
    $user = auth()->guard('moonshine')->user();
    abort_unless($user && ($user->isAdmin() || $user->isCoordinador()), 403);
    return app(ExportController::class)->studentReportPdf($id);
})->name('exports.student.pdf');