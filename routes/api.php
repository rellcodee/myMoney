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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FinancialEventsController;
use App\Http\Controllers\CategoryController;
use App\Models\AllocationProfile;
use App\Models\AllocationRule;
use Illuminate\Http\Request;
use App\Http\Controllers\AllocationProfileController;
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

Route::middleware('auth:sanctum')->get('/me/dashboard',[DashboardController::class,'boot']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/allocate', [AllocationController::class, 'store']);
    Route::get('/allocations', [AllocationController::class, 'index']);
    Route::get('/allocations/{id}', [AllocationController::class, 'show']);
    Route::get('/accounts/{id}/transactions', [AccountController::class, 'transactions']);
    Route::get('/accounts', [AccountController::class, 'index']);
    Route::get('/accounts/summary', [AccountController::class, 'summary']);
    Route::get('/accounts/{id}', [AccountController::class, 'showById']);
    Route::get('/financialevents', [FinancialEventsController::class, 'index']);
    Route::get('/summary', [ReportController::class, 'now']);
    Route::post('/transfer', [TransferController::class, 'transfer']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/events', [EventController::class, 'index']);
    Route::post('/expense', [ExpenseController::class, 'store']);
    Route::post('/income', [IncomeController::class, 'store']);
    Route::get('/reports/monthly', [ReportController::class, 'monthly']);
    Route::get('/reports/expense-by-category', [ReportController::class, 'expenseByCategory']);
    Route::get('/categories', [CategoryController::class, 'categories']);
    Route::post('/category', [CategoryController::class, 'store']);
    Route::get('/me', [AuthController::class,'me']);
    Route::post('/logout', [AuthController::class,'logout']);
    Route::post('/account', [AccountController::class, 'store']);
    Route::patch('/accounts/{id}/toggle', [AccountController::class, 'toggle']);
    Route::get('/allocation-profile/active', [AllocationProfileController::class, 'active']);
    Route::post('/allocation-profile', [AllocationProfileController::class, 'store']);
});