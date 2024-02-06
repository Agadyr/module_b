<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['middleware' => 'auth'], function () {
    Route::get('/homepage', [\App\Http\Controllers\TokenController::class, 'homepage'])->name('homepage');
    Route::delete('/homepage/{workspace}/delete', [\App\Http\Controllers\TokenController::class, 'deleteWorkSpace'])->name('deleteWorkSpace');
    Route::post('/homepage/create', [\App\Http\Controllers\TokenController::class, 'createWorkSpace'])->name('createWorkSpace');
    Route::get('/homepage/{workspace}', [\App\Http\Controllers\TokenController::class, 'showWorkSpace'])->name('showWorkSpace');
    Route::get('/homepage/{workspace}/edit', [\App\Http\Controllers\TokenController::class, 'editWorkSpace'])->name('editWorkSpace');
    Route::put('/homepage/{workspace}/edit', [\App\Http\Controllers\TokenController::class, 'storeWorkSpace'])->name('storeWorkSpace');
    Route::post('/homepage/{workspace}/create', [\App\Http\Controllers\TokenController::class, 'createToken'])->name('createToken');
    Route::get('/homepage/{token}/delete', [\App\Http\Controllers\TokenController::class, 'deleteToken'])->name('deleteToken');
    Route::post('/homepage/{workspace}/create/quota', [\App\Http\Controllers\TokenController::class, 'createQuota'])->name('createQuota');
    Route::delete('/homepage/{quota}/delete/quota', [\App\Http\Controllers\TokenController::class, 'deleteQuota'])->name('deleteQuota');
    Route::get('/homepage/{workspace}/billings', [\App\Http\Controllers\TokenController::class, 'billings'])->name('billings');
});
Route::get('/login',[\App\Http\Controllers\TokenController::class,'loginpage'])->name('loginPage');
Route::post('/login',[\App\Http\Controllers\TokenController::class,'login'])->name('login');
Route::get('/register',[\App\Http\Controllers\TokenController::class,'registerpage']);
Route::post('/register',[\App\Http\Controllers\TokenController::class,'register'])->name('register');
Route::get('/logout',[\App\Http\Controllers\TokenController::class,'logout'])->name('logout');
