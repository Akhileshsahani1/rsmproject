<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\Employee\Auth\ChangePasswordController;
use App\Http\Controllers\Employee\Auth\ForgotPasswordController;
use App\Http\Controllers\Employee\Auth\LoginController;
use App\Http\Controllers\Employee\Auth\RegisterController;
use App\Http\Controllers\Employee\Auth\ResetPasswordController;
use App\Http\Controllers\Employee\ChatController;
use App\Http\Controllers\Employee\DashboardController;
use App\Http\Controllers\Employee\OnboardingController;
use App\Http\Controllers\Employee\JobController;
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

Route::group(['prefix' => 'employee', 'as' => 'employee.'], function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication Routes | LOGIN | REGISTER
    |--------------------------------------------------------------------------
    */

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('register');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/update', [ResetPasswordController::class, 'reset'])->name('password.update');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('upload-avatar', [OnboardingController::class, 'uploadAvatar'])->name('upload-avatar');

    Route::get('onboarding/process', [OnboardingController::class, 'process'])->name('onboarding.process');
    Route::post('onboarding/process', [OnboardingController::class, 'saveProcess'])->name('onboarding.process');

    Route::get('approval/pending', [AssetController::class, 'employeeApproval'])->name('approval');

    Route::post('job/applied', [JobController::class, 'applyJob'])->name('job.apply');

    Route::post('job/bookmark', [JobController::class, 'jobBookmark'])->name('job.bookmark');

    Route::get('my-profile', [OnboardingController::class, 'myProfile'])->name('my-profile');
    Route::get('edit-profile', [OnboardingController::class, 'editProfile'])->name('edit-profile');
    Route::post('my-profile', [OnboardingController::class, 'saveProfile'])->name('my-profile');

    Route::get('change-password', [ChangePasswordController::class, 'changePasswordForm'])->name('password.form');
    Route::post('change-password', [ChangePasswordController::class, 'changePassword'])->name('change-password');

    Route::get('job/{id}/bookmark', [JobController::class, 'bookmark'])->name('job.bookmark');

    Route::get('bookmarks', [JobController::class, 'getBookmarks'])->name('bookmarks');

    Route::get('applied-jobs',[JobController::class,'appliedJobs'])->name('applied-jobs');
    Route::get('awarded-jobs',[JobController::class,'awardedJobs'])->name('awarded-jobs');
    Route::get('rejected-jobs',[JobController::class,'rejectedJobs'])->name('rejected-jobs');

    Route::get('chats', [ChatController::class, 'index'])->name('chats.index');
    Route::get('chats/{id}/show', [ChatController::class, 'show'])->name('chats.show');
    Route::post('chats/messages', [ChatController::class, 'messages'])->name('chats.messages');
    Route::post('chats/send-message', [ChatController::class, 'sendMessage'])->name('chats.send-message');
    Route::post('initiate-chat', [ChatController::class, 'initiate'])->name('initiate-chat');
    Route::post('chat/unseen/count',[ChatController::class,'getUnseenMessage'])->name('chats.unseen-message-count');

    Route::get('application/{id}/cancel', [JobController::class, 'cancel'])->name('application.cancel');

    Route::get('job/{id}/accept-document-request/{job_id}/job', [JobController::class, 'acceptRequestDocument'])->name('accept.request-document');
    Route::get('job/{id}/rejectt-document-request/{job_id}/job', [JobController::class, 'rejectRequestDocument'])->name('reject.request-document');

    Route::get('employee-notifications',[DashboardController::class,'notificationsEmployee'])->name('notifications');
    Route::any('employee-notifications/read',[DashboardController::class,'employeeReadNotifications'])->name('notifications.read');
    Route::get('employee-notifications/delete',[DashboardController::class,'emloyeeDeleteNotifications'])->name('notifications.delete');
});
