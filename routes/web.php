<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeManagementController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    // --- 1. THE BRIDGE ROUTE (Fixes 'Route [dashboard] not defined') ---
    // URL: /dashboard
    // Logic: Checks role and sends them to the specific URL
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('employee.dashboard');
    })->name('dashboard');


    // --- 2. EMPLOYEE ROUTES ---
    // URL: /employee/dashboard (Changed from /dashboard to prevent loop)
    Route::get('/employee/dashboard', [WorkOrderController::class, 'dashboard'])
         ->name('employee.dashboard');

    Route::get('/request/create', [WorkOrderController::class, 'create'])
         ->name('employee.create');

    Route::post('/request/store', [WorkOrderController::class, 'store'])
         ->name('employee.store');

    Route::get('/employee/history', [WorkOrderController::class, 'history'])->name('employee.history');

    Route::get('/notifications/read/{id}', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Add this new route for editing
    Route::patch('/request/{id}/update', [WorkOrderController::class, 'updateRequest'])
         ->name('employee.request.update');


    Route::patch('/request/{id}/update', [WorkOrderController::class, 'updateRequest'])->name('employee.request.update');
    Route::delete('/request/{id}/delete', [WorkOrderController::class, 'destroyRequest'])->name('employee.request.delete');

    // --- 3. PROFILE ROUTES ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// --- 4. ADMIN ROUTES ---
Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
         ->name('admin.dashboard');

    Route::get('/admin/requests', [AdminController::class, 'index'])
         ->name('admin.requests.index');

    // Route to SHOW the update page
    Route::get('/admin/request/{id}/edit', [AdminController::class, 'editStatus'])
        ->name('admin.edit');

    // FIX: Changed name to 'admin.requests.update' to avoid conflict
    Route::patch('/admin/request/{id}/update', [AdminController::class, 'updateStatus'])
        ->name('admin.requests.update');

    Route::get('/admin/reports', [AdminController::class, 'reportsIndex'])
        ->name('admin.reports.index');

    Route::get('/admin/reports/{id}/print', [AdminController::class, 'printReport'])
         ->name('admin.reports.print');

    Route::post('/admin/reports/preview', [AdminController::class, 'previewReport'])
        ->name('admin.reports.preview');

    Route::resource('admin/employees', EmployeeManagementController::class)
         ->names([
             'index' => 'admin.employees.index',
             'create' => 'admin.employees.create',
             'store' => 'admin.employees.store',
             'edit' => 'admin.employees.edit',
             'update' => 'admin.employees.update', // This name is now unique
             'destroy' => 'admin.employees.destroy',
         ]);
    // Add this line:
    Route::get('/admin/alerts', [AdminController::class, 'alerts'])->name('admin.alerts');
    Route::get('/admin/notifications', [NotificationController::class, 'index'])
        ->name('admin.notifications.index');
    Route::post('/admin/notifications/send', [NotificationController::class, 'sendMessage'])
        ->name('admin.notifications.send');
});

require __DIR__.'/auth.php';
