<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Employer\JobController;
use App\Http\Controllers\Employer\ChatController;
use App\Http\Controllers\Employer\OnboardingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Auth;

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



Route::get('/', [HomeController::class, 'home'])->name('frontend.index');
Route::get('/ai-recommendation', [HomeController::class, 'recommendation'])->name('frontend.ai-recommendation');
Route::get('/jobs', [HomeController::class, 'jobs'])->name('frontend.jobs');
Route::get('/job/show/{id}', [HomeController::class, 'jobShow'])->name('frontend.job.show');
Route::post('/job/referjob', [HomeController::class, 'referFriend'])->name('frontend.refer.job');
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('get-sub-classifications', [AssetController::class, 'getSubClassification'])->name('get-sub-classifications');

Route::post('get-areas', [AssetController::class, 'getAreas'])->name('get-areas');

Route::post('get-sub-zones', [AssetController::class, 'getSubZones'])->name('get-sub-zones');

Route::get('approval/pending', [AssetController::class, 'employerApproval'])->name('approval');

Route::get('onboarding/process', [OnboardingController::class, 'stepOne'])->name('onboarding.process');
Route::post('onboarding/process', [OnboardingController::class, 'saveStepOne'])->name('onboarding.process');

Route::get('my-profile', [OnboardingController::class, 'myProfile'])->name('my-profile');
Route::get('edit-profile', [OnboardingController::class, 'myEditProfile'])->name('edit-profile');
Route::post('my-profile', [OnboardingController::class, 'saveProfile'])->name('my-profile');

Route::get('page/{sug}', [AssetController::class, 'page'])->name('page');

Route::get('applicant/{slug}', [JobController::class, 'viewApplicant'])->name('view.applicant');
Route::get('applicant/bookmark/{slug}', [JobController::class, 'viewBookmarkApplicant'])->name('view.applicant.bookmark');

Route::post('upload-avatar', [OnboardingController::class, 'uploadAvatar'])->name('upload-avatar');

Route::get('change-password', [ChangePasswordController::class, 'changePasswordForm'])->name('password.form');
Route::post('change-password', [ChangePasswordController::class, 'changePassword'])->name('change-password');

Route::get('contact-us', [AssetController::class, 'contactUs'])->name('contact-us');
Route::post('contact-us', [AssetController::class, 'sendMessage'])->name('contact-us');

Route::get('post-job', [JobController::class, 'index'])->name('post-job');

Route::post('post-job', [JobController::class, 'postJob'])->name('post-job');

Route::get('edit-job/{id}', [JobController::class, 'edit'])->name('edit-job');

Route::post('update-job/{id}', [JobController::class, 'updateJob'])->name('update-job');

Route::get('open-jobs', [JobController::class, 'openJobs'])->name('open-jobs');

Route::get('closed-jobs', [JobController::class, 'closedJobs'])->name('closed-jobs');

Route::get('job/applicants/{id}', [JobController::class, 'applicants'])->name('job.applicants');

Route::get('job/application/{id}/accept', [JobController::class, 'accept'])->name('job.accept');

Route::get('job/application/{id}/reject', [JobController::class, 'reject'])->name('job.reject');

Route::get('chats', [ChatController::class, 'index'])->name('chats.index');
Route::get('chats/{id}/show', [ChatController::class, 'show'])->name('chats.show');
Route::post('chats/messages', [ChatController::class, 'messages'])->name('chats.messages');
Route::post('chats/send-message', [ChatController::class, 'sendMessage'])->name('chats.send-message');
Route::post('initiate-chat', [ChatController::class, 'initiate'])->name('initiate-chat');
Route::post('chat/unseen/count',[ChatController::class,'getUnseenMessage'])->name('chats.unseen-message-count');

Route::get('employee/{id}/bookmark', [JobController::class, 'bookmark'])->name('employee.bookmark');
Route::get('employee/{id}/document', [JobController::class, 'document'])->name('employee.documents');

Route::get('bookmarks', [JobController::class, 'getBookmarks'])->name('bookmarks');
Route::get('employee/{id}/request-document/{job_id}/job', [JobController::class, 'requestDocument'])->name('employee.request-document');

Route::get('employer/notifications', [HomeController::class, 'notificationsEmployer'])->name('notifications');
Route::any('notifications/read', [HomeController::class, 'employeerReadNotifications'])->name('notifications.read');
Route::get('notifications/delete', [HomeController::class, 'employeerDeleteNotifications'])->name('notifications.delete');
