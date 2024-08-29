<?php

use App\Http\Controllers\Admin\Auth\ChangePasswordController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\MyAccountController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\EmployerController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\UserManagement\AdminController;
use App\Http\Controllers\Admin\UserManagement\SuperadminController;
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

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication Routes | LOGIN | REGISTER
    |--------------------------------------------------------------------------
    */

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/update', [ResetPasswordController::class, 'reset'])->name('password.update');



    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Notifications Route
    |--------------------------------------------------------------------------
    */

    Route::resource('notifications', NotificationController::class);


    /*
    |--------------------------------------------------------------------------
    | Admins Route
    |--------------------------------------------------------------------------
    */


    Route::resource('user-management/admins', AdminController::class, [
        'names' => [
            'index'         => 'admins.index',
            'create'        => 'admins.create',
            'update'        => 'admins.update',
            'edit'          => 'admins.edit',
            'store'         => 'admins.store',
            'show'          => 'admins.show',
            'destroy'       => 'admins.destroy',
        ]
    ]);

    Route::get('user-management/admins/change-status/{id}', [AdminController::class, 'changeStatus'])->name('admins.change-status');
    Route::post('user-management/admins/reset-password', [AdminController::class, 'resetPassword'])->name('admins.reset-password');
    Route::post('user-management/admins/bulk-delete', [AdminController::class, 'bulkDelete'])->name('admins.bulk-delete');

    /*
    |--------------------------------------------------------------------------
    | Superadmins Route
    |--------------------------------------------------------------------------
    */
    Route::resource('user-management/superadmins', SuperadminController::class, [
        'names' => [
            'index'         => 'superadmins.index',
            'create'        => 'superadmins.create',
            'update'        => 'superadmins.update',
            'edit'          => 'superadmins.edit',
            'store'         => 'superadmins.store',
            'show'          => 'superadmins.show',
            'destroy'       => 'superadmins.destroy',
        ]
    ]);

    Route::get('user-management/superadmins/change-status/{id}', [SuperadminController::class, 'changeStatus'])->name('superadmins.change-status');
    Route::post('user-management/superadmins/reset-password', [SuperadminController::class, 'resetPassword'])->name('superadmins.reset-password');
    Route::post('user-management/superadmins/bulk-delete', [SuperadminController::class, 'bulkDelete'])->name('superadmins.bulk-delete');

     /*
    |--------------------------------------------------------------------------
    | Employers Route
    |--------------------------------------------------------------------------
    */


    Route::resource('employers', EmployerController::class);

    Route::get('employers/{id}/approve', [EmployerController::class, 'approvalForm'])->name('employers.approval-form');

    Route::put('employers/{id}/approve', [EmployerController::class, 'approve'])->name('employers.approve');

    Route::get('employers/change-status/{id}', [EmployerController::class, 'changeStatus'])->name('employers.change-status');
    Route::post('employers/reset-password', [EmployerController::class, 'resetPassword'])->name('employers.reset-password');
    Route::post('employers/bulk-delete', [EmployerController::class, 'bulkDelete'])->name('employers.bulk-delete');

    /*
    |--------------------------------------------------------------------------
    | Employees Route
    |--------------------------------------------------------------------------
    */


    Route::resource('employees', EmployeeController::class);

    Route::get('employees/{id}/approve', [EmployeeController::class, 'approvalForm'])->name('employees.approval-form');

    Route::put('employees/{id}/approve', [EmployeeController::class, 'approve'])->name('employees.approve');

    Route::get('employees/change-status/{id}', [EmployeeController::class, 'changeStatus'])->name('employees.change-status');
    Route::post('employees/reset-password', [EmployeeController::class, 'resetPassword'])->name('employees.reset-password');
    Route::post('employees/bulk-delete', [EmployeeController::class, 'bulkDelete'])->name('employees.bulk-delete');
    Route::post('employees/document-delete', [EmployeeController::class, 'documentDelete'])->name('employees.document-delete');
    /*
    |--------------------------------------------------------------------------
    | Job Route
    |--------------------------------------------------------------------------
    */


    Route::resource('jobs', JobController::class);
    Route::post('jobs/bulk-delete', [JobController::class, 'bulkDelete'])->name('jobs.bulk-delete');
    Route::get('jobs/{id}/approve', [JobController::class, 'approvalForm'])->name('jobs.approval-form');
    Route::get('jobs/{id}/applicants', [JobController::class, 'applicants'])->name('jobs.applicants');
    Route::get('jobs/{id}/view-applicant', [JobController::class, 'viewApplicant'])->name('jobs.view.applicant');
     /*
    |--------------------------------------------------------------------------
    | Pages Route
    |--------------------------------------------------------------------------
    */

    Route::resource('skills', SkillController::class);
    Route::resource('pages', PageController::class);

    /*
    |--------------------------------------------------------------------------
    | Settings > My Account Route
    |--------------------------------------------------------------------------
    */
    Route::resource('settings/my-account', MyAccountController::class);

    /*
    |--------------------------------------------------------------------------
    | Settings > Change Password Route
    |--------------------------------------------------------------------------
    */
    Route::get('settings/change-password', [ChangePasswordController::class, 'changePasswordForm'])->name('password.form');

    Route::post('settings/change-password', [ChangePasswordController::class, 'changePassword'])->name('change-password');

    Route::get('settings/company-details', [CompanyController::class, 'companyDetailsForm'])->name('company-details.form');

    Route::post('settings/company-details', [CompanyController::class, 'companyDetails'])->name('company-details');
});
