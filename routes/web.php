<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProjectController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'project'], function () {
    Route::get('/', [ProjectController::class, 'index'])->name('project.index');
    Route::post('/register', [ProjectController::class, 'register'])->name('project.register');
    Route::get('/git-pull', [ProjectController::class, 'gitPull'])->name('project.gitPull');
    Route::get('/detail', [ProjectController::class, 'detail'])->name('project.detail');
    Route::post('/edit-project', [ProjectController::class, 'editProject'])->name('project.editProject');
});
