<?php

use Illuminate\Support\Facades\Route;

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
    $stats = [
        'students' => \App\Models\User::students()->count(),
        'staff' => \App\Models\User::staff()->count(),
    ];
    return view('welcome', compact('stats'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard/stats', [App\Http\Controllers\HomeController::class, 'getStats'])->name('dashboard.stats');

Route::group(['prefix' => 'front-office', 'namespace' => 'App\Http\Controllers\FrontOffice'], function () {
    Route::resource('inquiries', 'InquiryController');
});

Route::group(['prefix' => 'academics', 'namespace' => 'App\Http\Controllers\Academics', 'middleware' => ['auth', 'role:admin']], function () {
    Route::resource('classes', 'AcademicClassController');
    Route::resource('sections', 'SectionController');
    Route::resource('subjects', 'SubjectController');
});

Route::group(['prefix' => 'admin', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth', 'role:admin']], function () {
    Route::resource('students', 'StudentController');
    Route::resource('staff', 'StaffController');
    
    // Attendance
    Route::get('attendance/report', 'AttendanceController@report')->name('attendance.report');
    Route::get('attendance', 'AttendanceController@index')->name('attendance.index');
    Route::get('attendance/create', 'AttendanceController@create')->name('attendance.create');
    Route::post('attendance', 'AttendanceController@store')->name('attendance.store');

    // Fees
    Route::get('fees/types', 'FeeController@indexTypes')->name('fees.types.index');
    Route::post('fees/types', 'FeeController@storeType')->name('fees.types.store');
    Route::delete('fees/types/{id}', 'FeeController@destroyType')->name('fees.types.destroy');
    Route::get('fees/receipt/{id}', 'FeeController@receipt')->name('fees.receipt');
    Route::resource('fees', 'FeeController');

    // Events
    Route::resource('events', 'EventController');

    // Examination
    Route::group(['namespace' => 'Examination'], function() {
        Route::resource('exams', 'ExamController');
        Route::resource('exam-schedules', 'ExamScheduleController');
        // Marks
        Route::get('marks', 'MarkController@index')->name('marks.index');
        Route::post('marks', 'MarkController@store')->name('marks.store');

        // Reports
        Route::get('reports', 'ReportController@index')->name('reports.index');
        Route::post('reports/generate', 'ReportController@generate')->name('reports.generate');

        // Admit Cards / Gate Pass
        Route::get('admit-cards', 'AdmitCardController@index')->name('admit-cards.index');
        Route::post('admit-cards/generate', 'AdmitCardController@generate')->name('admit-cards.generate');
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');

    // Notifications
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.readAll');
});
