<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\roleController;


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
Route::post('/roles', [roleController::class, 'addRole']);
