<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('/users',App\Http\Controllers\Api\UserController::class);
Route::apiResource('/works',App\Http\Controllers\Api\WorkController::class);
Route::apiResource('/provinsi',App\Http\Controllers\Api\ProvinsiController::class);
Route::apiResource('/kabupaten',App\Http\Controllers\Api\KabupatenController::class);
Route::apiResource('/kecamatan',App\Http\Controllers\Api\KecamatanController::class);
Route::apiResource('/desa',App\Http\Controllers\Api\DesaController::class);
