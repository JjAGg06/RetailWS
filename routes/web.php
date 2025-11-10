<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthMockController,
    DashboardController,
    EtlController,
    UploadsController,
    LogsController,
    ApiMockController
};

/*
|--------------------------------------------------------------------------
| Rutas Web - Comercio Minorista
|--------------------------------------------------------------------------
|
| Aplicación demo que simula login por roles, dashboards,
| procesos ETL, carga de archivos y logs, todo con datos mock.
|
*/

Route::get('/', fn() => redirect()->route('login'));

/* ============================
 |   Autenticación Mock
 ============================ */
Route::get('/login',  [AuthMockController::class, 'show'])->name('login');
Route::post('/login', [AuthMockController::class, 'login'])->name('login.do');
Route::get('/logout', [AuthMockController::class, 'logout'])->name('logout');

/* ============================
 |   Rutas protegidas (roles)
 ============================ */
Route::middleware(\App\Http\Middleware\RoleMock::class)->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/etl',       [EtlController::class,       'index'])->name('etl');
    Route::get('/uploads',   [UploadsController::class,   'index'])->name('uploads');
    Route::get('/logs',      [LogsController::class,      'index'])->name('logs');
    Route::get('/twofa', fn() => view('twofa'))->name('twofa');
});

/* ============================
 |   Endpoints Mock (API)
 ============================ */
Route::prefix('api/mock')->group(function () {
    Route::get('/sales', [ApiMockController::class, 'sales'])->name('api.sales');
    Route::get('/logs',  [ApiMockController::class, 'logs'])->name('api.logs');
});
