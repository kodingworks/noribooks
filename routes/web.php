<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('/', function () {
    return redirect(route('dashboard.index'));
});

Route::prefix('admin')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'login');
        Route::middleware(['auth'])->group(function () {
            Route::post('logout', 'logout')->name('logout');
        });
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/', function () {
            return redirect(route('dashboard.index'));
        });

        Route::controller(DashboardController::class)->middleware('can:view_general_dashboard')->group(function () {
            Route::get('/dashboard', 'index')->name('dashboard.index');
        });

        require __DIR__ . '/admin/settings.php';
        require __DIR__ . '/admin/accounting.php';
        // require __DIR__ . '/admin/core.php';
    });
});