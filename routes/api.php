<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\PendonoranController;
use App\Http\Controllers\UserController;

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

Route::resource('user', UserController::class)->middleware(['auth:api', 'role']);
Route::resource('pendonoran', PendonoranController::class)->middleware(['auth:api', 'role']);
