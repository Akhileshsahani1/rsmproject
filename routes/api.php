<?php
//Employer

use App\Http\Controllers\Admin\EmployerController;
use App\Http\Controllers\Api\User\Auth\AuthController;
use App\Http\Controllers\Api\User\JobController;
use App\Http\Controllers\Api\User\EmployerAssetController;
//Employee
use App\Http\Controllers\Api\Employee\Auth\EmployeeAuthController;
use App\Http\Controllers\Api\Employee\EmployeeAssetsController;
use App\Http\Controllers\Api\Employee\EmployeeJobController;
use App\Http\Controllers\Employee\Auth\ForgotPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Unauthenticated Routes Employer

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);
Route::get('employer-onboard-data', [AuthController::class, 'onBoardData']);
Route::get('post-job-data',[JobController::class,'postJobData']);
Route::post('get-subclassification',[JobController::class,'getSubClassification']);
Route::get('get-areas',[JobController::class,'getAreas']);
Route::get('get-subzone',[JobController::class,'getSubZones']);
Route::get('submit-support',[EmployerAssetController::class,'sendQuery']);

// Authenticated Routes Employer
Route::group(['middleware' => ['auth:api', 'scopes:user']], function () {
    Route::get('details', [AuthController::class, 'details']);
    Route::post('employee-onboard-process', [AuthController::class, 'onBoardProcess']);

    Route::get('recent-jobs', [JobController::class, 'recentJobs']);
    Route::get('all-jobs', [JobController::class, 'allJobs']);
    Route::get('view-job/{job_id}', [JobController::class, 'viewJob']);
    Route::post('closed-job/{job_id}', [JobController::class, 'closedJob']);
    Route::post('applied-applicants/{job_id}', [JobController::class, 'appliedApplicant']);
    Route::post('white-listed-applicants/{job_id}', [JobController::class, 'whiteListedApplicant']);
    Route::post('rejected-applicants/{job_id}', [JobController::class, 'rejectedApplicant']);

    Route::post('employee-bookmark/{employee_id}/{type}', [JobController::class, 'employeeBookmark']);
    Route::post('employee-whitelisted/{applied_id}', [JobController::class, 'employeeWhiteList']);
    Route::post('employee-rejected/{applied_id}', [JobController::class, 'employeeReject']);

    Route::post('request-document/{employee_id}/{job_id}', [JobController::class, 'requestDocument']);
    Route::get('document/{employee_id}', [JobController::class, 'document']);
    Route::post('view-employee/{employee_id}/{job_id}', [JobController::class, 'viewEmployee']);

    Route::post('employer-view-profile', [AuthController::class, 'viewProfile']);
    Route::post('employer-edit-profile', [AuthController::class, 'editProfile']);
    Route::post('employer-edit-avatar', [AuthController::class, 'editAvatar']);

    Route::get('employer-chat-list', [EmployerAssetController::class, 'chatList']);
    Route::get('employer-chat', [EmployerAssetController::class, 'messages']);
    Route::post('employer-send-message', [EmployerAssetController::class, 'sendMessage']);
    Route::post('employer-read-messages', [EmployerAssetController::class, 'readMessages']);

    Route::get('employer-notifications', [EmployerAssetController::class, 'notifications']);
    Route::post('employer-mark-read-notifications', [EmployerAssetController::class, 'markReadAll']);
    Route::post('employer-bell-notice', [EmployerAssetController::class, 'bellNotice']);

    Route::post('post-job',[JobController::class,'postJob']);
    Route::post('view-applicant',[AuthController::class,'viewApplicant']);
    Route::get('employer-bookmarks',[JobController::class,'listBookmarks']);
    Route::post('send-query',[EmployerAssetController::class,'sendQuery']);

    Route::post('doc-request',[EmployerAssetController::class,'docRequest']);

    Route::post('get-awarded-employees', [EmployerAssetController::class, 'getAwardedEmployees']);
    Route::post('get-employee-timings', [EmployerAssetController::class, 'getEmployeeTimings']);
    Route::post('update-employee-timing', [EmployerAssetController::class, 'updateEmployeeTiming']);
    Route::post('intiate-chat', [EmployerAssetController::class, 'intiateChat']);
    // User Logout Api
    Route::post('logout', [AuthController::class, 'logout']);
});





/*****************************EMPLOYEE APIS*****************************************************************/

Route::group(['middleware' => ['auth:employee-api', 'scopes:employee']], function () {

    Route::get('details', [EmployeeAuthController::class, 'details']);
    Route::get('employee-board-data', [EmployeeAuthController::class, 'onBoardingData']);
    Route::post('register-onboard', [EmployeeAuthController::class, 'registerOnboarding']);
    Route::post('employee-apply-job', [EmployeeJobController::class, 'applyJob']);
    Route::post('employee-bookmark-job', [EmployeeJobController::class, 'bookmarkJob']);
    Route::post('employee-bookmarks', [EmployeeJobController::class, 'employeeBookmarkJob']);
    Route::post('employee-search-jobs', [EmployeeJobController::class, 'searchJobs']);
    Route::post('employee-jobs', [EmployeeJobController::class, 'employeeJobs']);
    Route::post('employee-job-detail', [EmployeeJobController::class, 'jobDetail']);
    Route::post('employee-jobs-dashboard', [EmployeeJobController::class, 'dashboardJobs']);
    Route::post('employee-check-bookmark', [EmployeeJobController::class, 'checkBookMark']);
    Route::post('employee-profile', [EmployeeAuthController::class, 'employeeFullData']);
    Route::post('employee-notifications', [EmployeeAssetsController::class, 'notifications']);
    Route::post('employee-mark-read-notifications', [EmployeeAssetsController::class, 'markReadAll']);
    Route::post('employee-bell-notice', [EmployeeAssetsController::class, 'bellNotice']);
    Route::post('employee-update-profile', [EmployeeAuthController::class, 'employeeUpdateProfile']);
    Route::post('update-picture', [EmployeeAuthController::class, 'updatePicture']);
    Route::get('employee-chat-list', [EmployeeAssetsController::class, 'chatList']);
    Route::get('employee-chat', [EmployeeAssetsController::class, 'messages']);
    Route::post('employee-send-message', [EmployeeAssetsController::class, 'sendMessage']);
    Route::post('employee-read-messages', [EmployeeAssetsController::class, 'readMessages']);

    Route::post('add-attendance',[EmployeeAssetsController::class,'addAttendance']);
    Route::get('attendances',[EmployeeAssetsController::class,'attendance']);
    Route::get('employee-awarded-jobs',[EmployeeJobController::class,'getAwardedJobs']);

    //profile update
    Route::post('update-profile-step-one',[EmployeeAuthController::class,'stepOneUpdate']);
    Route::post('update-profile-step-two',[EmployeeAuthController::class,'stepTwoUpdate']);
    Route::post('update-profile-step-three',[EmployeeAuthController::class,'stepThreeUpdate']);
    Route::post('update-profile-docs',[EmployeeAuthController::class,'uploadDocs']);
    Route::get('employee-get-docs',[EmployeeAuthController::class,'getDocs']);
    // User Logout Api
    Route::post('employee-logout', [EmployeeAuthController::class, 'logout']);
});


//unauthenticated Routes for Employee
Route::post('employee-login', [EmployeeAuthController::class, 'login']);
Route::post('employee-register', [EmployeeAuthController::class, 'register']);
Route::get('employee-search-jobs', [EmployeeJobController::class, 'searchJobs']);
Route::get('employee-job-detail', [EmployeeJobController::class, 'jobDetail']);
Route::get('employee-password-reset', [ForgotPasswordController::class, 'sendResetLinkEmail']);
