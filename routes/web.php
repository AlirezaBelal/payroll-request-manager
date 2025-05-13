<?php

use App\Http\Controllers\ExpenseExportController;
use App\Http\Controllers\ProfileController;
use App\Livewire\AdminDashboardComponent;
use App\Livewire\AllExpensesComponent;
use App\Livewire\AllNotifications;
use App\Livewire\CreateExpenseRequest;
use App\Livewire\FinanceApprovalComponent;
use App\Livewire\HrApprovalComponent;
use App\Livewire\ReportsComponent;
use App\Livewire\UserExpenseList;
use App\Livewire\UserManagementComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', App\Livewire\Dashboard::class)
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // مسیرهای پروفایل کاربر
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // مسیرهای درخواست هزینه (برای همه کاربران)
    Route::get('/expenses/create', CreateExpenseRequest::class)->name('expenses.create');
    Route::get('/expenses/my', UserExpenseList::class)->name('expenses.my');

    // مسیرهای نوتیفیکیشن
    Route::get('/notifications', AllNotifications::class)->name('notifications.index');

    // مسیرهای منابع انسانی
    Route::middleware(['role:hr'])->prefix('hr')->group(function () {
        Route::get('/expenses/pending', HrApprovalComponent::class)->name('hr.expenses.pending');
    });

    // مسیرهای واحد مالی
    Route::middleware(['role:finance'])->prefix('finance')->group(function () {
        Route::get('/expenses/pending', FinanceApprovalComponent::class)->name('finance.expenses.pending');
        Route::get('/expenses/export', [ExpenseExportController::class, 'export'])->name('finance.expenses.export');
    });

    // مسیرهای سوپر ادمین
    Route::middleware(['role:super_admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', AdminDashboardComponent::class)->name('admin.dashboard');
        Route::get('/users', UserManagementComponent::class)->name('admin.users');
        Route::get('/expenses/all', AllExpensesComponent::class)->name('admin.expenses.all');
        Route::get('/expenses/view/{expense}', [AllExpensesComponent::class, 'view'])->name('admin.expenses.view');
        Route::get('/reports', ReportsComponent::class)->name('admin.reports');
    });
});

require __DIR__ . '/auth.php';
