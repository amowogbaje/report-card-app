<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\PaymentController;

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
    return redirect('/login');
});
Route::get('/artisan-calls', function() {
    $exitCode = Artisan::call('make:job UndoStudentBootstrap');
    return $exitCode;
});

Route::get('/set-password', [HomeController::class, 'setPassword']);
Route::get('/reset-passwords', [HomeController::class, 'resetPassword']);

Route::get('/migrate-seed', function() {
    $exitCode = Artisan::call('migrate:fresh --seed');
    return $exitCode;
});

Route::get('/make-model', function() {
    $exitCode = Artisan::call('make:model PromotionList -m');
    return $exitCode;
});
Route::get('/migrate', function() {
    $exitCode = Artisan::call('migrate --path=/database/migrations/2023_08_03_113757_create_promotion_lists_table.php');
    return $exitCode;
});
Route::view('/comeback', 'comeback')->name('comeback');
Route::view('/404', '404')->name('not-found');
Route::view('/403', '403')->name('unauthorized');
Route::get('/timetable', [DashboardController::class, 'timetable']);
Route::get('/little-errands', [DashboardController::class, 'littleErrands']);
Route::get('/update-student-with-class-code', [ResultController::class, 'updateStudentWithClassCode']);
Route::get('/update-result-with-class-code', [ResultController::class, 'updateResultWithClassCode']);
Route::get('/delete-result-without-subject-teacher', [ResultController::class, 'deleteResultWithoutSubjectTeacher']);
Route::get('/update-result-with-grade/{class_code}/{subject_id}', [ResultController::class, 'updateGradesForSeniorStudents']);
Route::get('/generate-email', [HomeController::class, 'generateRandomEmail']);
Route::get('/update-student-who-paid', [ResultController::class, 'confirmStudentWhoPaid']);
Route::get('/update-subject-in-result/{id}/{changedId}', [AdminController::class, 'updateSubjectId']);

Route::get('/student-payment-status/', [AdminController::class, 'setPaymentStatusNull'])->name('admin-payment-status');

Route::get('/change-password', [AdminController::class, 'changePasswordPage'])->name('change-password');
Route::post('/change-password', [AdminController::class, 'changePasswordAction'])->name('change-password-action');

// Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
Route::get('/admin/school/info', [AdminController::class, 'schoolInfo'])->name('admin.school-info')->middleware('admin');
Route::group(['prefix'=>'admin', 'middleware' => ['auth','admin', 'candoActivities']], function(){
    Route::view('/setup', 'admin.setup')->name('admin.setup');
    Route::view('/principal-broadsheet', 'admin.principal-broadsheet');
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::post('/select-result-session', [DashboardController::class, 'setSessionTerm'])->name('select-result-session');
    Route::get('/class-teacher-comment-missing', [DashboardController::class, 'classTeacherCommentsMissing'])->name('comments-missing');
    
    // Route::get('/school/info', [AdminController::class, 'schoolInfo'])->name('admin.school-info');
    Route::get('/subject-allocation', [AdminController::class, 'subjectAllocation'])->name('admin.subject-allocation');
    Route::get('/classes', [AdminController::class, 'classPage'])->name('admin.classes');
    Route::get('/subjects', [AdminController::class, 'subjects'])->name('admin.classes');
    Route::get('/teachers', [AdminController::class, 'teachers'])->name('admin.teachers');
    Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
    Route::get('/results', [DashboardController::class, 'subjectTeachers'])->name('admin.results');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::get('/profile/edit', [AdminController::class, 'editProfile'])->name('admin.profile-edit');
    Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile-update');
    Route::get('/set-school', [AdminController::class, 'setSchoolName']);
    Route::get('class/{class_id}/subject/{subject_id}/spreadsheet', [ResultController::class, 'teacherspreadsheetforAdmin'])->name('admin.teacher.spreadsheet');
    // Route::get('/profile/{id}', [ProfileController::class, 'viewTeacherProfile'])->name('admin.teacher.profile');
    // Route::get('/profile/{id}/edit', [ProfileController::class, 'editTeacherProfile'])->name('admin.teacher.profile-edit');
    // Route::post('/profile/edit', [ProfileController::class, 'editTeacherAction'])->name('admin.teacher.profile-edit-action');
    // Route::get('/class/{class_id}/subject/{subject_id}/spreadsheet', [ResultController::class, 'teacherspreadsheet'])->name('admin.teacher.spreadsheet');
    // Route::post('/submit/scores', [ResultController::class, 'submitScores'])->name('admin.teacher.submit-scores');

    Route::get('/change-password/{id}', [AdminController::class, 'changePasswordPage'])->name('admin-change-password');
});



Route::group(['prefix'=>'teacher', 'middleware' => ['auth', 'teacher', 'candoActivities']], function(){
    Route::get('/profile', [TeacherController::class, 'profile'])->name('admin.profile');
    Route::get('/profile/edit', [TeacherController::class, 'editProfile'])->name('admin.profile-edit');
    Route::post('/profile/update', [TeacherController::class, 'updateProfile'])->name('teacher.profile-update');
    Route::post('/register-student-for-subject', [TeacherController::class, 'registerStudent'])->name('register-student-for-subject');
    Route::get('/profile/{id}', [ProfileController::class, 'viewTeacherProfile'])->name('teacher.profile');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'editTeacherProfile'])->name('teacher.profile-edit');
    // Route::post('/profile/edit-teacher', [ProfileController::class, 'editTeacherAction'])->name('teacher.profile-edit-action');
    Route::get('/class/{class_id}/subject/{subject_id}/spreadsheet', [ResultController::class, 'teacherspreadsheet'])->middleware('subject.teacher')->name('teacher.spreadsheet');
    Route::post('/submit/scores', [ResultController::class, 'submitScores'])->name('teacher.submit-scores');
    Route::get('/dashboard', [DashboardController::class, 'teacher'])->name('teacher.dashboard');
    Route::get('/subjects', [TeacherController::class, 'subjects'])->name('teacher.profile');
    Route::get('/class-assigned', [TeacherController::class, 'classAssigned'])->name('teacher.class-assigned');
    Route::get('/subject-registration/class/{class_id}/subject/{subject_id}', [ProfileController::class, 'subjectRegistration'])->name('teacher.subject-registration')->middleware('subject.teacher');
});


Route::group(['prefix'=>'student', 'middleware' => ['auth', 'candoActivities']], function(){
    Route::get('/profile/{id}', [ProfileController::class, 'viewStudentProfile'])->name('student.profile');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'editStudentProfile'])->name('student.profile-edit')->middleware('teacher');
    Route::post('/profile/edit-student', [ProfileController::class, 'editStudentAction'])->name('student.profile-edit-action');
    Route::get('/{student_id}/academic-report', [ProfileController::class, 'academicReport'])->name('student.academic-report');
    Route::get('/dashboard', [DashboardController::class, 'student'])->name('student.dashboard');
    Route::get('/{student_id}/download-result', [ResultController::class, 'downloadResult'])->name('student.download-result');
    Route::get('/{student_id}/{given_term_id}/{given_session_id}/download-result', [ResultController::class, 'downloadPreviousResult'])->name('student.download-previous-result');
    Route::get('/transactions', [PaymentController::class, 'index'])->name('student.payment-index');
    Route::post('/transactions', [PaymentController::class, 'index'])->name('student.payment');
    Route::get('/subject-offered', [ProfileController::class, 'subjectOfferedByStudent'])->name('student.subject-offered');
});




// Route::post('/teacher/add', [TeacherController::class, 'add'])->name('teacher.add');

require __DIR__.'/auth.php';
