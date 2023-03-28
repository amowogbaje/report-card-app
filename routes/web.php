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
    return redirect('http://ambassadorscollege.com.ng/');
});
Route::view('/comeback', 'comeback')->name('comeback');
Route::get('/timetable', [DashboardController::class, 'timetable']);
Route::get('/generate-email', [HomeController::class, 'generateRandomEmail']);
Route::get('/generate-phone', [HomeController::class, 'generateRandomPhoneNo']);

Route::get('/change-password', [AdminController::class, 'changePasswordPage'])->name('change-password');
Route::post('/change-password', [AdminController::class, 'changePasswordAction'])->name('change-password-action');

// Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
Route::get('/admin/school/info', [AdminController::class, 'schoolInfo'])->name('admin.school-info');
Route::group(['prefix'=>'admin', 'middleware' => ['auth', 'candoActivities']], function(){
    Route::view('/setup', 'admin.setup')->name('admin.setup');
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    // Route::get('/school/info', [AdminController::class, 'schoolInfo'])->name('admin.school-info');
    Route::get('/subject-allocation', [AdminController::class, 'subjectAllocation'])->name('admin.subject-allocation');
    Route::get('/classes', [AdminController::class, 'classPage'])->name('admin.classes');
    Route::get('/subjects', [AdminController::class, 'subjects'])->name('admin.classes');
    Route::get('/teachers', [AdminController::class, 'teachers'])->name('admin.teachers');
    Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
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



Route::group(['prefix'=>'teacher', 'middleware' => ['auth', 'candoActivities']], function(){
    Route::get('/profile', [TeacherController::class, 'profile'])->name('admin.profile');
    Route::get('/profile/edit', [TeacherController::class, 'editProfile'])->name('admin.profile-edit');
    Route::post('/profile/update', [TeacherController::class, 'updateProfile'])->name('admin.profile-update');
    
    Route::get('/profile/{id}', [ProfileController::class, 'viewTeacherProfile'])->name('teacher.profile');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'editTeacherProfile'])->name('teacher.profile-edit');
    Route::post('/profile/edit-teacher', [ProfileController::class, 'editTeacherAction'])->name('teacher.profile-edit-action');
    Route::get('/class/{class_id}/subject/{subject_id}/spreadsheet', [ResultController::class, 'teacherspreadsheet'])->name('teacher.spreadsheet');
    Route::post('/submit/scores', [ResultController::class, 'submitScores'])->name('teacher.submit-scores');
    Route::get('/dashboard', [DashboardController::class, 'teacher'])->name('teacher.dashboard');
    Route::get('/subjects', [TeacherController::class, 'subjects'])->name('teacher.profile');
    Route::get('/class-assigned', [TeacherController::class, 'classAssigned'])->name('teacher.class-assigned');
});


Route::group(['prefix'=>'student', 'middleware' => ['auth', 'candoActivities']], function(){
    Route::get('/profile/{id}', [ProfileController::class, 'viewStudentProfile'])->name('student.profile');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'editStudentProfile'])->name('student.profile-edit');
    Route::post('/profile/edit-student', [ProfileController::class, 'editStudentAction'])->name('student.profile-edit-action');
    Route::get('/{student_id}/academic-report', [ProfileController::class, 'academicReport'])->name('student.academic-report');
    Route::get('/dashboard', [DashboardController::class, 'student'])->name('student.dashboard');
    Route::get('/{student_id}/download-result', [ResultController::class, 'downloadResult'])->name('student.download-result');
    Route::get('/transactions', [PaymentController::class, 'index'])->name('student.payment-index');
    Route::post('/transactions', [PaymentController::class, 'index'])->name('student.payment');
    Route::get('/subject-offered', [ProfileController::class, 'subjectOfferedByStudent'])->name('student.subject-offered');
});




// Route::post('/teacher/add', [TeacherController::class, 'add'])->name('teacher.add');

require __DIR__.'/auth.php';
