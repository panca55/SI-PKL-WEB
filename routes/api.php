<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Student\EvaluationController as StudentEvaluationController;
use App\Http\Controllers\Admin\EvaluationController as AdminEvaluationController;
use App\Http\Controllers\Teacher\EvaluationController as TeacherEvaluationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Corporation\ProfileController as CorporationProfileController;
use App\Http\Controllers\Corporation\DashboardController;
use App\Http\Controllers\Instructor\ProfileController as InstructorProfileController;
use App\Http\Controllers\Teacher\ProfileController as TeacherProfileController;
use App\Http\Controllers\Student\LogbookController;
use App\Http\Controllers\Student\InternshipController as StudentInternshipController;
use App\Http\Controllers\Admin\InternshipController as AdminInternshipController;
use App\Http\Controllers\Admin\CorporationController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\InformationController;
use App\Http\Controllers\Admin\InstructorController;
use App\Http\Controllers\Admin\MayorController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Corporation\BursaController;
use App\Http\Controllers\Corporation\SiswaController as CorporationSiswaController;
use App\Http\Controllers\Instructor\BimbinganController as InstructorBimbinganController;
use App\Http\Controllers\Teacher\BimbinganController as TeacherBimbinganController;
use App\Http\Controllers\Instructor\SertifikatController;
use App\Http\Controllers\Pimpinan\SiswaController;
use App\Http\Controllers\Teacher\AssessmentController;

// Admin Routes
Route::prefix('admin')
    ->namespace('Admin')
    ->middleware(['auth:api', 'isAdmin']) // Menggunakan auth:api untuk autentikasi API
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', 'UserController@dashboard')->name('dashboard');
        Route::patch('user/{user}/toggle-active', 'UserController@toggleActive')->name('user.toggleActive');
        Route::apiResource('user', 'UserController');  // Menggunakan apiResource untuk API
        Route::apiResource('student', 'StudentController');
        Route::apiResource('teacher', 'TeacherController');
        Route::apiResource('corporation', 'CorporationController');
        Route::apiResource('instructor', 'InstructorController');
        Route::apiResource('department', 'DepartmentController');
        Route::apiResource('mayor', 'MayorController');
        Route::apiResource('evaluation', 'EvaluationController');
        Route::apiResource('internship', 'InternshipController');
        Route::apiResource('information', 'InformationController');
    });

Route::prefix('student')
    ->namespace('Student')
    ->middleware(['auth:api', 'siswa'])  // auth:api untuk autentikasi API
    ->name('student.')
    ->group(function () {
        Route::get('/dashboard', 'ProfileController@dashboard')->name('dashboard');
        Route::apiResource('profile', 'ProfileController');
        Route::apiResource('internship', 'InternshipController');
        Route::post('/internship/logbook', 'InternshipController@logbookStore')->name('logbookStore');
        Route::apiResource('logbook', 'LogbookController');
        Route::get('/check-evaluation-availability', 'EvaluationController@checkEvaluationAvailability');
        Route::apiResource('evaluation', 'EvaluationController');
        Route::get('evaluation/{id}/print', 'EvaluationController@print')->name('evaluation.print');
    });

// Student Routes
Route::prefix('teacher')
    ->namespace('Teacher')
    ->middleware(['auth:api', 'guru'])  // auth:api untuk autentikasi API
    ->name('teacher.')
    ->group(function () {
        Route::get('/dashboard', 'ProfileController@dashboard')->name('dashboard');
        Route::apiResource('profile', 'ProfileController');
        Route::apiResource('bimbingan', 'BimbinganController');
        Route::get('bimbingan/logbook/{id}', 'BimbinganController@detailLogbook')->name('detailLogbook');
        Route::apiResource('assessment', 'AssessmentController');
        Route::get('assessments/{id}/create', 'AssessmentController@createAssessment')->name('createAssessment');
        Route::get('assessments/{id}/print', 'AssessmentController@print')->name('assessments.print');
        Route::get('assessments/{id}/detail', 'AssessmentController@detail')->name('assessments.detail');
        Route::apiResource('evaluation', 'EvaluationController');
    });

Route::prefix('corporation')
    ->namespace('Corporation')
    ->middleware(['auth:api', 'perusahaan'])  // auth:api untuk autentikasi API
    ->name('corporation.')
    ->group(function () {
        Route::apiResource('dashboard', 'DashboardController');
        Route::post('/assign-instructor', 'DashboardController@assignInstructor')->name('dashboard.assignInstructor');
        Route::apiResource('profile', 'ProfileController');
        Route::apiResource('bursa', 'BursaController');
        Route::patch('job/{job}/toggle-active', 'BursaController@toggleActive')->name('bursa.toggleActive');
        Route::apiResource('siswa', 'SiswaController');
    });

Route::prefix('instructor')
    ->namespace('Instructor')
    ->middleware(['auth:api', 'instruktur'])  // auth:api untuk autentikasi API
    ->name('instructor.')
    ->group(function () {
        Route::get('/dashboard', 'ProfileController@dashboard')->name('dashboard');
        Route::apiResource('profile', 'ProfileController');
        Route::apiResource('bimbingan', 'BimbinganController');
        Route::get('bimbingan/logbook/{id}', 'BimbinganController@detailLogbook')->name('detailLogbook');
        Route::apiResource('sertifikat', 'SertifikatController');
        Route::post('/sertifikat/create', 'SertifikatController@storeSertifikat')->name('storeSertifikat');
    });

/*----------------------------REST API-------------------------------------*/
// API Login POST
Route::middleware('api')->post('login', [AuthenticatedSessionController::class, 'store']);
Route::middleware('auth:sanctum')->post('/logout', [AuthenticatedSessionController::class, 'destroy']);
// API reset password
Route::middleware('api')->post('/password/forgot', [PasswordResetLinkController::class, 'store']);
Route::middleware('api')->post('/register', [RegisteredUserController::class, 'store']);
Route::middleware('api')->post('/password/new', [NewPasswordController::class, 'store']);
Route::middleware('auth:sanctum')->put('/password/update', [PasswordController::class, 'update']);

// Evaluation Student
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/evaluation/check', [StudentEvaluationController::class, 'checkEvaluationAvailability']);
    Route::get('/evaluation/index', [StudentEvaluationController::class, 'index']);
    Route::post('/evaluation/store', [StudentEvaluationController::class, 'store']);
    Route::get('/evaluation/print/{id}', [StudentEvaluationController::class, 'print']);
});

// Evaluation Admin
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/evaluation', [AdminEvaluationController::class, 'index']);
    Route::get('/admin/evaluation/sertifikat/{id}', [AdminEvaluationController::class, 'printSertifikat']);
    Route::get('/admin/evaluation/show/{id}', [AdminEvaluationController::class, 'show']);
    Route::get('/admin/evaluation/detail/{id}', [AdminEvaluationController::class, 'detail']);
    Route::post('/admin/evaluation', [AdminEvaluationController::class, 'store']);
    Route::put('/admin/evaluation/{id}', [AdminEvaluationController::class, 'update']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/teacher/evaluation', [TeacherEvaluationController::class, 'index']);
    Route::get('/teacher/evaluation/print/{id}', [TeacherEvaluationController::class, 'print']);
    Route::get('/teacher/evaluation/create/{id}', [TeacherEvaluationController::class, 'createEvaluation']);
    Route::get('/teacher/evaluation/{id}', [TeacherEvaluationController::class, 'show']);
    Route::post('/teacher/evaluation', [TeacherEvaluationController::class, 'store']);
    Route::put('/teacher/evaluation/{id}', [TeacherEvaluationController::class, 'update']);
});


// API Logbook
Route::middleware('auth:sanctum')->group(function () {
    Route::get('logbook', [LogbookController::class, 'index']);          // GET: List semua logbook
    Route::get('logbook/{id}', [LogbookController::class, 'show']);       // GET: Detail logbook by ID
    Route::get('logbook/{id}/print', [LogbookController::class, 'print']); // GET: Cetak logbook menjadi PDF

    // Placeholder rute jika create/store/edit/update/destroy diimplementasikan
    Route::post('logbook/', [LogbookController::class, 'store']);         // POST: Tambah logbook baru
    Route::put('logbook/{id}', [LogbookController::class, 'update']);     // PUT: Update logbook by ID
    Route::delete('logbook/{id}', [LogbookController::class, 'destroy']); // DELETE: Hapus logbook by ID
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/siswa', [ProfileController::class, 'dashboard']); // Get profile
    Route::get('/profil/siswa', [ProfileController::class, 'index']); // Get profile
    Route::post('/profil/siswa', [ProfileController::class, 'store']); // Create profile
    Route::put('/profil/siswa/{id}', [ProfileController::class, 'update']); // Update profile
    Route::delete('/profil/siswa/{id}', [ProfileController::class, 'destroy']); // Delete profile
    Route::get('/profil/create', [ProfileController::class, 'create']); // GET: Data untuk membuat logbook
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/intern', [StudentInternshipController::class, 'index']);
    Route::post('/intern', [StudentInternshipController::class, 'store']);
    Route::get('/intern/{id}', [StudentInternshipController::class, 'show']);
    Route::put('/intern/edit/{id}', [StudentInternshipController::class, 'edit']);
    Route::put('/intern/update/{id}', [StudentInternshipController::class, 'update']);
    Route::delete('/intern/{id}', [StudentInternshipController::class, 'destroy']); //
    Route::post('/intern/logbook', [StudentInternshipController::class, 'logbookStore']);
});

// Test route tanpa auth untuk debugging upload
Route::post('/test-upload', function (Request $request) {
    return response()->json([
        'message' => 'Test upload endpoint',
        'method' => $request->method(),
        'content_type' => $request->header('Content-Type'),
        'content_length' => $request->header('Content-Length'),
        'has_file_field' => [
            'file' => $request->hasFile('file'),
            'photo' => $request->hasFile('photo'),
            'image' => $request->hasFile('image'),
        ],
        'all_files' => $request->allFiles(),
        'all_inputs' => $request->all(),
        'request_size' => strlen($request->getContent()),
        'php_max_filesize' => ini_get('upload_max_filesize'),
        'php_max_post_size' => ini_get('post_max_size'),
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/intern', [AdminInternshipController::class, 'index']);
    Route::get('/admin/intern/absen', [AdminInternshipController::class, 'rekapAbsensi']);
    Route::post('/admin/intern', [AdminInternshipController::class, 'store']);
    Route::put('/admin/intern/edit', [AdminInternshipController::class, 'edit']);
    Route::put('/admin/intern/update', [AdminInternshipController::class, 'update']);
    Route::delete('/admin/intern', [AdminInternshipController::class, 'destroy']);
    Route::get('/admin/rekapabsensi', [AdminInternshipController::class, 'rekapAbsensi']);
    // Route::get('/admin/rekapabsensi', [AdminInternshipController::class, 'getAllInternships']);

});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/korporat', [CorporationController::class, 'index']);
    Route::get('/korporat/create', [CorporationController::class, 'create']);
    Route::get('/korporat/cek', [CorporationController::class, 'checkSlug']);
    Route::post('/korporat', [CorporationController::class, 'store']);
    Route::put('/korporat/edit/{id}', [CorporationController::class, 'edit']);
    Route::put('/korporat/update/{id}', [CorporationController::class, 'update']);
    Route::delete('/korporat/{id}', [CorporationController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/department', [DepartmentController::class, 'index']);
    Route::post('/department', [DepartmentController::class, 'store']);
    Route::put('/department/edit', [DepartmentController::class, 'edit']);
    Route::put('/department/update', [DepartmentController::class, 'update']);
    Route::delete('/department', [DepartmentController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/info', [InformationController::class, 'index']);
    Route::post('/info', [InformationController::class, 'store']);
    Route::put('/info/{id}', [InformationController::class, 'update']);
    Route::delete('/info', [InformationController::class, 'destroy']);
});

// API admin instruktur
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/instruktur', [InstructorController::class, 'index']);
    Route::post('/instruktur', [InstructorController::class, 'store']);
    Route::put('/instruktur/{id}', [InstructorController::class, 'update']);
    Route::delete('/instruktur', [InstructorController::class, 'destroy']);
});

// API admin mayor
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/mayor', [MayorController::class, 'index']);
    Route::post('/mayor', [MayorController::class, 'store']);
    Route::put('/mayor', [MayorController::class, 'update']);
    Route::delete('/mayor', [MayorController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/student', [StudentController::class, 'index']);
    Route::post('/student', [StudentController::class, 'store']);
    Route::put('/student', [StudentController::class, 'update']);
    Route::delete('/student', [StudentController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/teacher', [TeacherController::class, 'index']);
    Route::post('/teacher', [TeacherController::class, 'store']);
    Route::post('/teacher/{id}', [TeacherController::class, 'update']);
    Route::delete('/teacher', [TeacherController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/create/user', [UserController::class, 'create']);
    Route::post('/users', [UserController::class, 'store']);
    Route::patch('/user/active', [UserController::class, 'toggleActive']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users', [UserController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/bursa', [BursaController::class, 'index']);
    Route::post('/bursa', [BursaController::class, 'store']);
    Route::put('/bursa/{id}', [BursaController::class, 'update']);
    Route::delete('/bursa/{id}', [BursaController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/corporate/profile', [CorporationProfileController::class, 'index']);
    Route::post('/corporate/profile', [CorporationProfileController::class, 'store']);
    Route::put('/corporate/profile/{id}', [CorporationProfileController::class, 'update']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/instruktur/profile', [InstructorProfileController::class, 'index']);
    Route::post('/instruktur/profile', [InstructorProfileController::class, 'store']);
    Route::put('/instruktur/profile/{id}', [InstructorProfileController::class, 'update']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/teacher/dashboard/', [TeacherProfileController::class, 'dashboard']);
    Route::get('/teacher/profile/', [TeacherProfileController::class, 'index']);
    Route::post('/teacher/profile', [TeacherProfileController::class, 'store']);
    Route::put('/teacher/profile/{id}', [TeacherProfileController::class, 'update']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/sertifikat', [SertifikatController::class, 'index']);
    Route::get('/sertifikat/{id}', [SertifikatController::class, 'show']);
    Route::post('/sertifikat', [SertifikatController::class, 'storeSertifikat']);
    Route::put('/sertifikat/{id}', [SertifikatController::class, 'update']);
    Route::get('/sertifikat/print/{id}', [SertifikatController::class, 'print']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/pimpinan/siswa', [SiswaController::class, 'siswaPkl']);
    Route::get('/pimpinan/siswa/{id}', [SiswaController::class, 'showSiswaPkl']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/instruktur/bimbingan', [InstructorBimbinganController::class, 'index']);
    Route::get('/instruktur/bimbingan/{id}', [InstructorBimbinganController::class, 'show']);
    Route::get('/instruktur/bimbingan/logbook/{id}', [InstructorBimbinganController::class, 'detailLogbook']);
    Route::post('/instruktur/bimbingan', [InstructorBimbinganController::class, 'store']);
    Route::put('/instruktur/bimbingan/update/{id}', [InstructorBimbinganController::class, 'update']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/teacher/bimbingan', [TeacherBimbinganController::class, 'index']);
    Route::get('/teacher/bimbingan/{id}', [TeacherBimbinganController::class, 'show']);
    Route::get('/teacher/bimbingan/logbook/{id}', [TeacherBimbinganController::class, 'detailLogbook']);
    Route::post('/teacher/bimbingan', [TeacherBimbinganController::class, 'store']);
    Route::put('/teacher/bimbingan/update/{id}', [TeacherBimbinganController::class, 'update']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/corporate/siswa', [CorporationSiswaController::class, 'index']);
    Route::get('/corporate/siswa/{id}', [CorporationSiswaController::class, 'show']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/corporate/dashboard', [DashboardController::class, 'index']);
    Route::post('/corporate/dashboard', [DashboardController::class, 'assignInstructor']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/assessment', [AssessmentController::class, 'index']);
    Route::get('/assessment/print/{id}', [AssessmentController::class, 'print']);
    Route::get('/assessment/create/{id}', [AssessmentController::class, 'createAssessment']);
    Route::get('/assessment/{id}', [AssessmentController::class, 'show']);
    Route::get('/assessment/detail/{id}', [AssessmentController::class, 'detail']);
    Route::put('/assessment/edit/{id}', [AssessmentController::class, 'edit']);
    Route::put('/assessment/update/{id}', [AssessmentController::class, 'update']);
    Route::post('/assessment', [AssessmentController::class, 'store']);
});

// Authenticated User Info
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
