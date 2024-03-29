<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\roleController;
use App\Http\Controllers\userController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\permissionController;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/*
|--------------------------------------------------------------------------
| CRUD users
|--------------------------------------------------------------------------
*/
Route::post('/users', [userController::class, 'addUser']);
Route::put('/users/{id}', [userController::class, 'editUser']);
Route::delete('/users/{id}', [userController::class, 'deleteUser']);



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



/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/
Route::namespace('Api')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
    });
    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('helloworld', [AuthController::class, 'index']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});



/*
|--------------------------------------------------------------------------
| Forgot-password
|--------------------------------------------------------------------------
*/
Route::post('/forgotPassword', [UserController::class, 'forgotPassword']);
Route::get('/mot-de-passe/reinitialiser/{token}', [UserController::class, 'showResetForm'])->name('password.reset');
Route::post('/mot-de-passe/reset/', [UserController::class, 'reset']);