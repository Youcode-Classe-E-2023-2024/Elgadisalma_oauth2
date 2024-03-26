<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\permissionController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| CRUD users
|--------------------------------------------------------------------------
*/
Route::post('/users', [userController::class, 'addUser']);



/*
|--------------------------------------------------------------------------
| CRUD roles
|--------------------------------------------------------------------------
*/
Route::get('/roles', [RoleController::class, 'showRoles']);
Route::post('/roles', [roleController::class, 'addRole']);
Route::delete('/roles/{id}', [roleController::class, 'deleteRole']);


/*
|--------------------------------------------------------------------------
| CRUD permissions
|--------------------------------------------------------------------------
*/
Route::get('/permissions', [permissionController::class, 'showPermissions']);
Route::post('/permissions', [permissionController::class, 'addPermission']);
Route::delete('/permissions/{id}', [permissionController::class, 'deletePermission']);
