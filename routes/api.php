<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\AllocationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;



Route::post('/income', [IncomeController::class, 'store']);
Route::post('/allocate', [AllocationController::class, 'allocate']);
Route::post('/expense', [ExpenseController::class, 'store']);
Route::post('/transfer', [TransferController::class, 'transfer']);
Route::get('/events', [EventController::class, 'index']);
Route::get('/accounts/{id}/transactions', [AccountController::class, 'transactions']);
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/accounts', [AccountController::class, 'index']);
Route::get('/reports/monthly', [ReportController::class, 'monthly']);
Route::get('/reports/expense-by-category', [ReportController::class, 'expenseByCategory']);
Route::get('/accounts/summary',[AccountController::class, 'summary']);