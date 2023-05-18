<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Settings\RoleManagementController;
use App\Http\Controllers\Settings\UserManagementController;

/*
|--------------------------------------------------------------------------
| Settings Routes
|--------------------------------------------------------------------------
|
| Here is where you can register setting related routes for your application.
|
*/

Route::prefix('settings')->name('settings.')->group(function () {
    Route::controller(RoleManagementController::class)->middleware('can:view_settings_role_management')->prefix('role')->name('role.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('get-data', 'getRoleList')->name('getdata');
        Route::get('add-role', 'createRolePage')->name('createpage');
        Route::get('{id}/edit-role', 'editRolePage')->name('editpage');
        Route::post('add-role', 'storeNewRole')->name('storerole');
        Route::put('{id}/update-role', 'updateRole')->name('updateRole');
        Route::delete('{id}/delete-role', 'deleteRole')->name('deleterole');
    });

    Route::controller(UserManagementController::class)->middleware('can:view_settings_user_management')->prefix('user')->name('user.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('get-data', 'getData')->name('getdata');
        Route::post('create', 'createData')->name('create');
        Route::post('{id}/update', 'updateData')->name('update');
        Route::delete('{id}/delete', 'deleteData')->name('delete');
    });
});
