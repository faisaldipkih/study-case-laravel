<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SigninController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RekeningNasabahController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\DesaController;

use App\Http\Middleware\AuthUser;
use App\Http\Middleware\AuthInUser;

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
Route::middleware(AuthInUser::class)->group(function(){
    Route::get('/',[SigninController::class,'index']);
});

Route::get('/user',[UserController::class,'index']);
Route::get('/user/list',[UserController::class,'getUser'])->name('user.list');
Route::put('/user/active',[UserController::class,'active']);

Route::get('/kabupaten/show-prov',[KabupatenController::class,'showProv']);
Route::get('/kecamatan/show-kab',[KecamatanController::class,'showKab']);
Route::get('/desa/show-kec',[DesaController::class,'showKec']);

Route::middleware(AuthUser::class)->group(function(){
    Route::get('/rekening-nasabah',[RekeningNasabahController::class,'index']);
});

Route::get('/rekening-nasabah/list',[RekeningNasabahController::class,'getRekening'])->name('rekening.list');
Route::post('/rekening-nasabah',[RekeningNasabahController::class,'store']);
Route::put('/rekening-nasabah/approve',[RekeningNasabahController::class,'approveRekening']);

Route::post('/signin',[SigninController::class,'signin']);
Route::get('/logout',[SigninController::class,'logout']);
