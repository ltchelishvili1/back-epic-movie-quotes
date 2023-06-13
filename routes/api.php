
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MovieController;
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
Route::patch('/user', [UserController::class, 'update'])->middleware('auth:sanctum')->name('user.update');


Route::post('/forgot-password', [ResetPasswordController::class, 'resetPassword'])->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'updatePassword'])->name('password.change');


Route::post('/check-token', [ResetPasswordController::class, 'checkToken']);

Route::get('/auth/google', [OAuthController::class, 'redirect'])->name('google.auth');
Route::get('auth/google/call-back', [OauthController::class, 'callbackGoogle'])->name('google.auth');

Route::post('/movies', [MovieController::class, 'store'])->middleware('auth:sanctum')->name('movie.store');
Route::get('/movies', [MovieController::class, 'index'])->middleware('auth:sanctum')->name('movie.index');

Route::get('/categories', [CategoryController::class, 'index'])->middleware('auth:sanctum')->name('category.index');



Route::middleware('auth:sanctum')->group(
    function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    }
);


Route::get('set-language/{language}', [LanguageController::class, 'setLanguage'])->name('set-language');
