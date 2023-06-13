
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
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
Route::get('/email/verify/{id}/{hash}', [EmailVerifyController::class, 'emailVerify'])->name('verification.verify');
Route::get('set-language/{language}', [LanguageController::class, 'setLanguage'])->name('set-language');

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('auth.login');
    Route::get('/logout', 'logout')->name('auth.logout');
});


Route::controller(ResetPasswordController::class)->group(function () {
    Route::post('/forgot-password', 'resetPassword')->name('password.reset');
    Route::post('/reset-password', 'updatePassword')->name('password.change');
    Route::post('/check-token', 'checkToken')->name('password.checkToken');
});

Route::controller(OAuthController::class)->group(function () {
    Route::get('/auth/google', 'redirect')->name('google.auth');
    Route::get('auth/google/call-back', 'callbackGoogle')->name('google.auth');

});


Route::middleware('auth:sanctum')->group(
    function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

        Route::controller(MovieController::class)->group(function () {
            Route::post('/movies', 'store')->name('movie.store');
            Route::get('/movies', 'index')->name('movie.index');
        });

        Route::get('/genres', [GenreController::class, 'index'])->name('genre.index');

        Route::controller(UserController::class)->group(function () {
            Route::get('/user', 'index')->name('user.index');
            Route::patch('/user', 'update')->name('user.update');
        });


    }
);
