<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Admin\GstReportController;
use App\Http\Controllers\Admin\AdminDashboardController;

use App\Http\Controllers\Staff\InvoiceController as StaffInvoiceController;
use App\Http\Controllers\Staff\StaffDashboardController;
use App\Http\Controllers\Admin\ActivityLogController;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return redirect()->route('login');

});

/*
|--------------------------------------------------------------------------
| HOME REDIRECT
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'approved'])->get('/home', function () {

    if (auth()->user()->role === 'admin') {

        return redirect()->route('admin.dashboard');

    }

    return redirect()->route('staff.dashboard');

})->name('home');

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ADMIN DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/dashboard',
        [AdminDashboardController::class, 'index']
    )->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | CUSTOMERS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'customers',
        CustomerController::class
    )->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | USERS (WITH APPROVAL & RESET LINK)
    |--------------------------------------------------------------------------
    */

    Route::post(
        'admin/users/{user}/approve',
        [UserController::class, 'approve']
    )->name('admin.users.approve');

    Route::post(
        'admin/users/{user}/send-reset-link',
        [UserController::class, 'sendResetLink']
    )->name('admin.users.sendResetLink');

    Route::resource(
        'admin/users',
        UserController::class
    )
    ->except(['show'])
    ->names('admin.users');

    /*
    |--------------------------------------------------------------------------
    | GST REPORTS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/gst-reports',
        [GstReportController::class, 'index']
    )->name('admin.gstReports.index');

    Route::get(
        '/admin/gst-reports/download',
        [GstReportController::class, 'download']
    )->name('admin.gstReports.download');

    /*
    |--------------------------------------------------------------------------
    | COMPANIES
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/companies',
        [CompanyController::class, 'index']
    )->name('companies.index');

    Route::get(
        '/companies/create',
        [CompanyController::class, 'create']
    )->name('companies.create');

    Route::post(
        '/companies',
        [CompanyController::class, 'store']
    )->name('companies.store');

    Route::get(
        '/companies/{company}/edit',
        [CompanyController::class, 'edit']
    )->name('companies.edit');

    Route::put(
        '/companies/{company}',
        [CompanyController::class, 'update']
    )->name('companies.update');

    /*
    |--------------------------------------------------------------------------
    | ADMIN INVOICES
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/invoices',
        [AdminInvoiceController::class, 'index']
    )->name('admin.invoices.index');

    Route::get(
        '/admin/invoices/{invoice}',
        [AdminInvoiceController::class, 'show']
    )->name('admin.invoices.show');

    Route::get(
    '/admin/activity-logs',
    [ActivityLogController::class, 'index']
)->name('admin.activityLogs.index');

});

/*
|--------------------------------------------------------------------------
| STAFF AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'approved'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | STAFF DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/staff/dashboard',
        [StaffDashboardController::class, 'index']
    )->name('staff.dashboard');

    /*
    |--------------------------------------------------------------------------
    | STAFF CUSTOMERS
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'staff/customers',
        CustomerController::class
    )
    ->except(['show'])
    ->names('staff.customers');

    /*
    |--------------------------------------------------------------------------
    | BULK DELETE INVOICES
    |--------------------------------------------------------------------------
    */

    Route::delete(
        'staff/invoices/bulk-delete',
        [StaffInvoiceController::class, 'bulkDelete']
    )->name('staff.invoices.bulkDelete');

    /*
    |--------------------------------------------------------------------------
    | UPDATE INVOICE ITEMS
    |--------------------------------------------------------------------------
    */

    Route::post(
        'staff/invoices/{invoice}/items',
        [StaffInvoiceController::class, 'updateItems']
    )->name('staff.invoices.updateItems');

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS + TRANSACTION
    |--------------------------------------------------------------------------
    */

    Route::put(
        'staff/invoices/{invoice}/status-with-transaction',
        [StaffInvoiceController::class, 'updateStatusWithTransaction']
    )->name('staff.invoices.updateStatusWithTransaction');

    Route::put(
        'staff/invoices/{invoice}/basic-details',
        [StaffInvoiceController::class, 'updateBasic']
    )->name('staff.invoices.updateBasic');

    /*
    |--------------------------------------------------------------------------
    | STAFF INVOICES
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'staff/invoices',
        StaffInvoiceController::class
    )
    ->only([
        'index',
        'create',
        'store',
        'edit',
        'show'
    ])
    ->names('staff.invoices');

});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

