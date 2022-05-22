<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\PendonoranController;
use App\Http\Controllers\UserController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/login', [UserController::class, 'login']);
Route::post('/user', [UserController::class, 'store']);

// USER
//Route::resource('user', UserController::class)->middleware(['auth:api', 'role']);

Route::middleware(['auth:api', 'role'])->group(function(){
    // List users
    Route::middleware(['scope:admin'])->get('/user', [UserController::class, 'index']);
    Route::middleware(['scope:admin'])->get('/user/create', [UserController::class, 'create']);
    Route::middleware(['scope:admin'])->delete('/user/{user}', [UserController::class, 'destroy']);
    Route::middleware(['scope:admin'])->put('/user/{user}', [UserController::class, 'update']);
    Route::middleware(['scope:admin,donor'])->get('/user/{user}', [UserController::class, 'show']);
    Route::middleware(['scope:admin'])->get('/user/{user}/edit', [UserController::class, 'edit']);
});

// PENDONORAN
//Route::resource('pendonoran', PendonoranController::class)->middleware(['auth:api', 'role']);
