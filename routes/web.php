<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

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

Route::get('/', [TaskController::class, 'index'])->name('tasks.index')->middleware('auth');
Route::get('create', [TaskController::class, 'create'])->name('tasks.create')->middleware('auth');
Route::post('/', [TaskController::class, 'store'])->name('tasks.store')->middleware('auth');
Route::get('edit/{id}', [TaskController::class, 'edit'])->name('tasks.edit')->middleware('auth');
Route::patch('edit/{id}', [TaskController::class, 'update'])->name('tasks.update')->middleware('auth');

Route::get('register', [RegisterController::class, 'create'])->name('register.create')->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->name('register.store')->middleware('guest');

Route::get('auth', [LoginController::class, 'create'])->name('auth.create')->middleware('guest');
Route::post('auth', [LoginController::class, 'store'])->name('auth.store')->middleware('guest');
Route::post('auth/logout', [LoginController::class, 'destroy'])->name('auth.destroy')->middleware('auth');
