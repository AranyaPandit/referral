<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvestmentController;

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

Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
Route::post('/admin/settings/update', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
Route::get('/admin/investments', [AdminController::class, 'investments'])->name('admin.investments');


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');




Route::middleware(['auth'])->group(function () {
    Route::get('/invest', [InvestmentController::class, 'showInvestForm'])->name('invest.form');
    Route::post('/invest', [InvestmentController::class, 'invest'])->name('invest');
    Route::get('/my-investments', [InvestmentController::class, 'myInvestments'])->name('user.investments');
});

