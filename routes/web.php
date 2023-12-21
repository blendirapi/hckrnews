<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoryController;


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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/new', [HomeController::class, 'new'])->name('new');

Route::get('/best', [HomeController::class, 'best'])->name('best');

Route::get('/user/{id}', [UserController::class, 'index'])->name('user');

Route::get('/story/{id}', [StoryController::class, 'index'])->name('story');