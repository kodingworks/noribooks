<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Accounting\AccountController;
use App\Http\Controllers\Accounting\CategoryController;
use App\Http\Controllers\Accounting\JournalController;


/*
|--------------------------------------------------------------------------
| Account Routes
|--------------------------------------------------------------------------
|
| Here is where you can register finger related routes for your application.
|
*/



Route::prefix('accounting')->name('accounting.')->group(function () {
    Route::controller(AccountController::class)->prefix('account')->name('account.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('get-data', 'getData')->name('getdata');
        Route::post('create', 'createData')->name('create');
        Route::post('{id}/update', 'updateData')->name('update');
        Route::delete('{id}/delete', 'deleteData')->name('delete');
    });
    
    Route::controller(CategoryController::class)->prefix('category')->name('category.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('get-data', 'getData')->name('getdata');
        Route::post('create', 'createData')->name('create');
        Route::post('{id}/update', 'updateData')->name('update');
        Route::delete('{id}/delete', 'deleteData')->name('delete');
    });
    Route::controller(JournalController::class)->prefix('journal')->name('journal.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('get-data', 'getData')->name('getdata');
        Route::get('create', 'createPage')->name('createPage');
        Route::post('store', 'createData')->name('store');
        Route::post('{id}/update', 'updateData')->name('update');
        Route::delete('{id}/delete', 'deleteData')->name('delete');
    });
});
