<?php

use App\Http\Controllers\ArchiveStudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PassiveStudentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\SocialLinksController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    return view('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('home', function () {
        return view('home');
    });
});


Route::middleware(['auth'])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('dashboard');
    Route::get('/payments/monthly', [MainController::class, 'monthlyPayments'])->name('payments.monthly');
    Route::get('/payments/yearly', [MainController::class, 'yearlyPayments'])->name('payments.yearly');

    // export url
    Route::get('/groups/export', [ExportController::class, 'export'])->name('groups.export');
    Route::get('/groups/archive/export', [ExportController::class, 'archiveExport'])->name('archiveGroups.export');
    Route::get('teachers/export/', [ExportController::class, 'teacherExport'])->name('teacher.export');
    Route::get('/students/export', [ExportController::class, 'studentExport'])->name('studentExport.export');
    Route::get('/passive-students/export', [ExportController::class, 'passiveStudentExport'])->name('passiveStudentExport.export');
    Route::get('/archive-students/export', [ExportController::class, 'archiveStudentExport'])->name('archiveStudentExport.export');
        Route::get('/attendance/download-pdf', [AttendanceController::class, 'downloadPdfReport'])->name('attendance.downloadPdf');


    // user url
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
    Route::get('/change-password', [UserController::class, 'changePassword'])->name('changePassword');
    Route::post('/change-password', [UserController::class, 'changePasswordSave'])->name('postChangePassword');

    // staff url
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{id}/update', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{id}/delete', [RoleController::class, 'destroy'])->name('roles.delete');

    // group url
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/archive', [GroupController::class, 'archive'])->name('groups.archive');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups/store', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/search', [GroupController::class, 'search'])->name('groups.search');
    Route::get('/groups/{id}', [GroupController::class, 'show'])->name('groups.show');
    Route::get('/groups/archive/{id}', [GroupController::class, 'archiveShow'])->name('groups.archiveShow');
    Route::get('/groups/{id}/edit', [GroupController::class, 'edit'])->name('groups.edit');
    Route::put('/groups/{id}/update', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('/groups/{id}/delete', [GroupController::class, 'destroy'])->name('groups.delete');

    // subject url
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::get('/subjects/search', [SubjectController::class, 'searchSubject'])->name('subjects.search');
    Route::get('/subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
    Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
    Route::get('/subject/{id}', [SubjectController::class, 'showHtml'])->name('subjects.showHtml');
    Route::get('/subjects/{id}', [SubjectController::class, 'show'])->name('subjects.show');
    Route::get('/subjects/{id}/edit', [SubjectController::class, 'edit'])->name('subjects.edit');
    Route::put('/subjects/{id}', [SubjectController::class, 'update'])->name('subjects.update');
    Route::delete('/subjects/{id}', [SubjectController::class, 'destroy'])->name('subjects.delete');

    // teacher url
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
    Route::get('/teachers/search', [TeacherController::class, 'searchTeacher'])->name('teachers.search');
    Route::get('/teachers/{id}', [TeacherController::class, 'show'])->name('teachers.show');
    Route::get('/teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{id}', [TeacherController::class, 'destroy'])->name('teachers.delete');

    // active student url 
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/search', [StudentController::class, 'searchStudent'])->name('students.search');
    Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.delete');

    // Passive Student Routes
    Route::get('/passive-students', [PassiveStudentController::class, 'index'])->name('passive-students.index');
    Route::get('/passive-students/create', [PassiveStudentController::class, 'create'])->name('passive-students.create');
    Route::post('/passive-students', [PassiveStudentController::class, 'store'])->name('passive-students.store');
    Route::get('/passive-students/search', [PassiveStudentController::class, 'searchPassiveStudent'])->name('passive-students.search');
    Route::get('/passive-students/{id}', [PassiveStudentController::class, 'show'])->name('passive-students.show');
    Route::get('/passive-students/{id}/edit', [PassiveStudentController::class, 'edit'])->name('passive-students.edit');
    Route::put('/passive-students/{id}', [PassiveStudentController::class, 'update'])->name('passive-students.update');
    Route::get('/passive-students/{id}/activation', [PassiveStudentController::class, 'activation'])->name('passive-students.activation');
    Route::put('/passive-students/{id}/activate', [PassiveStudentController::class, 'activate'])->name('passive-students.activate');
    Route::delete('/passive-students/{id}', [PassiveStudentController::class, 'destroy'])->name('passive-students.destroy');

    // Archive Students Routes
    Route::get('/archive-students', [ArchiveStudentController::class, 'index'])->name('archive-students.index');
    Route::get('/archive-students/search', [ArchiveStudentController::class, 'searchArchiveStudent'])->name('archive-students.search');

    // Attendance routes
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/search', [AttendanceController::class, 'searchAttendance'])->name('attendance.search');
    Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');

    //  payment url
    Route::get('/payments/search', [PaymentController::class, 'search'])->name('payments.search');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/history', [PaymentController::class, 'history'])->name('payments.history');
    Route::get('/payments/unpaid', [PaymentController::class, 'unpaid'])->name('payments.unpaid');

    Route::get('/student/payments/search', [PaymentController::class, 'searchStudentPayment'])->name('searchStudentPayment.search');
    Route::get('/payments/{id}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/create{id}', [PaymentController::class, 'create'])->name('payments.create');
    Route::get('/fetch-receipt-info', [PaymentController::class, 'fetchReceiptInfo'])->name('fetchReceiptInfo');
    Route::get('/payments/print/{id}', [PaymentController::class, 'printReceipt'])->name('payments.printReceipt');
    Route::post('/update-payment-status', [PaymentController::class, 'updatePaymentStatus'])->name('update.payment.status');
    Route::delete('/payments/{id}', [PaymentController::class, 'delete'])->name('payments.delete');

    // Social Links
    Route::get('/socilLinks', [SocialLinksController::class, 'index'])->name('socialLinks.index');
    Route::get('/socilLinks/create', [SocialLinksController::class, 'create'])->name('socialLinks.create');
    Route::post('/socilLinks', [SocialLinksController::class, 'store'])->name('socialLinks.store');
    Route::delete('/socilLinks/{id}', [SocialLinksController::class, 'destroy'])->name('socialLinks.delete');

    // Payment methods
    Route::get('/paymentMethods', [PaymentMethodsController::class, 'index'])->name('paymentMethods.index');
    Route::get('/paymentMethods/create', [PaymentMethodsController::class, 'create'])->name('paymentMethods.create');
    Route::post('/paymentMethods', [PaymentMethodsController::class, 'store'])->name('paymentMethods.store');
    Route::delete('/paymentMethods/{id}', [PaymentMethodsController::class, 'destroy'])->name('paymentMethods.delete');

    // sms url
    Route::get('/sms/create', [SMSController::class, 'create'])->name('sms.create');
    Route::post('/sms/send-sms-to-student', [SMSController::class, 'sendSmsToStudent'])->name('send.sms.student');
    Route::get('/sms/history', [SMSController::class, 'getAllSmsHistory'])->name('sms.history');

    // room urls
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{id}', [RoomController::class, 'show'])->name('rooms.show');
    Route::get('/rooms/{id}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{id}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{id}', [RoomController::class, 'destroy'])->name('rooms.delete');

});



require __DIR__ . '/auth.php';
