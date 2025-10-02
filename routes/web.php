<?php

use App\Http\Controllers\Admin\CorporationController;
use App\Http\Controllers\Admin\InternshipController;
use App\Http\Controllers\Corporation\BursaController;
use App\Http\Controllers\Corporation\ProfileController as CorporationProfileController;
use App\Http\Controllers\HomeController;
use App\Models\Information;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $informations = Information::all();
    return view('pages.frontend.home', compact('informations'));
})->name('home');

Route::controller(HomeController::class)->group(function () {
    Route::get('/mitra', 'mitra')->name('mitra');
    Route::get('/bursa-kerja', 'bursaKerja')->name('bursa-kerja');
    Route::get('/mitra/{slug}', 'detailPerusahaan')->name('mitra.detail');
    Route::get('/bursa-kerja/{slug}', 'detailBursa')->name('bursa.detail');
});

Route::prefix('admin')
    ->namespace('Admin')
    ->middleware(['auth', 'isAdmin'])
    ->name('admin/')
    ->group(function () {
        Route::get('/dashboard', 'UserController@dashboard')->name('dashboard');
        Route::patch('user/{user}/toggle-active', 'UserController@toggleActive')->name('user.toggleActive');
        Route::resource('user', 'UserController');
        Route::post('user/import', 'UserController@import')->name('user.import');
        Route::resource('student', 'StudentController');
        Route::get('/studentExport', 'StudentController@studentExport')->name('studentExport');
        Route::resource('teacher', 'TeacherController');
        Route::resource('corporation', 'CorporationController');
        Route::resource('instructor', 'InstructorController');
        Route::resource('department', 'DepartmentController');
        Route::resource('mayor', 'MayorController');
        Route::resource('evaluation', 'EvaluationController');
        Route::get('/evaluationExel', 'EvaluationController@evaluationExel')->name('evaluationExel');
        Route::get('evaluation/{id}/detail', 'EvaluationController@detail')->name('evaluation.detail');
        Route::post('/print-selected/{internship}', 'EvaluationController@printSelected')->name('print-selected');
        Route::get('evaluation/{id}/print', 'EvaluationController@printSertifikat')->name('printSertifikat');
        Route::get('evaluation/{id}/printNilaiakhir', 'EvaluationController@printNilaiakhir')->name('printNilaiakhir');
        Route::resource('internship', 'InternshipController');
        Route::get('rekapAbsensi', 'InternshipController@rekapAbsensi')->name('rekapAbsensi');
        Route::get('rekapJurnal', 'InternshipController@rekapJurnal')->name('rekapJurnal');
        Route::get('/exportAbsent', 'InternshipController@exportAbsent')->name('exportAbsent');
        Route::get('/export', 'InternshipController@exportExcel')->name('exportExcel');
        Route::resource('information', 'InformationController');
    });

Route::prefix('student')
    ->namespace('Student')
    ->middleware(['auth', 'siswa'])
    ->name('student/')
    ->group(function () {
        Route::get('/dashboard', 'ProfileController@dashboard')->name('dashboard');
        Route::resource('profile', 'ProfileController');
        Route::resource('internship', 'InternshipController');
        Route::get('/attendanceDetail', 'InternshipController@attendanceDetail')->name('attendanceDetail');
        Route::get('internship/{$id}', 'InternshipController@indexMagang')->name('indexMagang');
        Route::post('/internship/logbook', 'InternshipController@logbookStore')->name('logbookStore');
        Route::resource('logbook', 'LogbookController');
        Route::get('logbook/{id}/print', 'LogbookController@print')->name('logbook.print');
        Route::get('/check-evaluation-availability', 'EvaluationController@checkEvaluationAvailability');
        Route::resource('evaluation', 'EvaluationController');
        Route::get('evaluation/{id}/print', 'EvaluationController@print')->name('evaluation.print');
    });

Route::prefix('teacher')
    ->namespace('Teacher')
    ->middleware(['auth', 'guru'])
    ->name('teacher/')
    ->group(function () {
        Route::get('/dashboard', 'ProfileController@dashboard')->name('dashboard');
        Route::resource('profile', 'ProfileController');
        Route::resource('bimbingan', 'BimbinganController');
        Route::get('bimbingan/logbook/{id}', 'BimbinganController@detailLogbook')->name('detailLogbook');
        Route::resource('assessment', 'AssessmentController');
        Route::get('assessments/{id}/create', 'AssessmentController@createAssessment')->name('createAssessment');
        Route::get('assessments/{id}/print', 'AssessmentController@print')->name('assessments.print');
        Route::get('assessments/{id}/detail', 'AssessmentController@detail')->name('assessments.detail');
        Route::resource('evaluation', 'EvaluationController');
        Route::get('evaluation/{id}/create', 'EvaluationController@createEvaluation')->name('createEvaluation');
        Route::get('evaluation/{id}/print', 'EvaluationController@print')->name('evaluation.print');
    });

Route::prefix('corporation')
    ->namespace('Corporation')
    ->middleware(['auth', 'perusahaan'])
    ->name('corporation/')
    ->group(function () {
        Route::resource('dashboard', 'DashboardController');
        Route::post('/assign-instructor', 'DashboardController@assignInstructor')->name('dashboard.assignInstructor');
        Route::resource('profile', 'ProfileController');
        Route::resource('bursa', 'BursaController');
        Route::patch('job/{job}/toggle-active', 'BursaController@toggleActive')->name('bursa.toggleActive');
        Route::resource('siswa', 'SiswaController');
    });

Route::prefix('instructor')
    ->namespace('Instructor')
    ->middleware(['auth', 'instruktur'])
    ->name('instructor/')
    ->group(function () {
        Route::get('/dashboard', 'ProfileController@dashboard')->name('dashboard');
        Route::resource('profile', 'ProfileController');
        Route::resource('bimbingan', 'BimbinganController');
        Route::get('bimbingan/logbook/{id}', 'BimbinganController@detailLogbook')->name('detailLogbook');
        Route::resource('sertifikat', 'SertifikatController');
        Route::get('sertifikat/{id}/create', 'SertifikatController@createSertifikat')->name('createSertifikat');
        Route::post('/sertifikat/create', 'SertifikatController@storeSertifikat')->name('storeSertifikat');
        Route::get('sertifikat/{id}/print', 'SertifikatController@print')->name('sertifikat.print');
    });

Route::prefix('pimpinan')
    ->namespace('Pimpinan')
    ->middleware(['auth', 'waka.group'])
    ->name('pimpinan/')
    ->group(function () {
        Route::get('/dashboard', 'SiswaController@dashboard')->name('dashboard');
        Route::get('/siswa-pkl', 'SiswaController@siswaPkl')->name('siswaPkl');
        Route::get('/siswa-pkl/{id}', 'SiswaController@showSiswaPkl')->name('showSiswaPkl');
        Route::get('/siswa', 'SiswaController@siswa')->name('siswa');
    });

Route::get('/profile/checkSlug', [CorporationProfileController::class, 'checkSlug'])->middleware('auth');
Route::get('/corporation/checkSlug', [CorporationController::class, 'checkSlug'])->middleware('auth');
Route::get('/bursa/checkSlug', [BursaController::class, 'checkSlug'])->middleware('auth');

// Route for serving storage files with CORS
Route::get('/storage/public/{path}', function ($path) {
    Log::info('Serving storage file: ' . $path);
    $fullPath = storage_path('app/public/' . $path);
    Log::info('Full path: ' . $fullPath);
    Log::info('File exists: ' . (file_exists($fullPath) ? 'yes' : 'no'));
    if (!file_exists($fullPath)) {
        abort(404);
    }
    $mime = mime_content_type($fullPath);
    $content = file_get_contents($fullPath);
    return \Illuminate\Support\Facades\Response::make($content, 200, [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET',
        'Access-Control-Allow-Headers' => 'Content-Type',
        'Content-Type' => $mime,
    ]);
})->where('path', '.*')->withoutMiddleware([\Illuminate\Http\Middleware\HandleCors::class, \Illuminate\Session\Middleware\StartSession::class, \Illuminate\View\Middleware\ShareErrorsFromSession::class, \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

require __DIR__ . '/auth.php';
