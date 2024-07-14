<?php

use App\Http\Controllers\Onfido\OnfidoController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/register', [OnfidoController::class, 'index'])->name('register');
Route::get('/completed', [OnfidoController::class, 'completed'])->name('completed');
Route::post('/register', [OnfidoController::class, 'register'])->name('register.applicant');
Route::post('/create/workflow', [OnfidoController::class, 'create_workflow'])->name('create.workflow');
Route::get('/run/onfido', [OnfidoController::class, 'run'])->name('run.onfido');
