
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('/email/verify/{id}/{hash}', [EmailVerifyController::class, 'emailVerify'])->name('verification.verify');

Route::get('/user', [UserController::class, 'index'])->middleware('auth:sanctum')->name('user.index');


Route::post('/forgot-password', [ResetPasswordController::class, 'resetPassword'])->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'updatePassword'])->name('password.change');


Route::post('/check-token', [ResetPasswordController::class, 'checkToken']);

Route::middleware('auth:sanctum')->group(
    function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    }
);
