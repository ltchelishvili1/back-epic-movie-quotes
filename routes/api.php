<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QuoteController;
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
    Route::post('/login', 'login')->middleware('ensure.email.verified')->name('auth.login');

});


Route::controller(ResetPasswordController::class)->group(function () {
    Route::post('/forgot-password', 'resetPassword')->name('password.reset');
    Route::post('/reset-password', 'updatePassword')->name('password.change');
    Route::post('/check-token', 'checkToken')->name('password.checkToken');
});

Route::controller(OAuthController::class)->group(function () {
    Route::get('/auth/google', 'redirect')->name('google.auth');
    Route::get('auth/google/call-back', 'callbackGoogle')->name('google.callback');

});


Route::middleware('auth:sanctum')->group(
    function () {
        Route::get('/logout', [AuthController::class, 'logut'])->name('auth.logout');

        Route::controller(MovieController::class)->group(function () {
            Route::post('/movies', 'store')->name('movies.store');
            Route::get('/movies', 'index')->name('movies.index');
            Route::get('/movies/{movie}', 'show')->middleware('can:update-movie,movie')->name('movies.show');
            Route::delete('/movies/{movie}', 'destroy')->middleware('can:update-movie,movie')->name('movies.destroy');
            Route::patch('/movies/{movie}', 'update')->middleware('can:update-movie,movie')->name('movies.update');
        });


        Route::controller(QuoteController::class)->group(function () {
            Route::get('/quotes', 'index')->name('quote.index');
            Route::post('/quotes', 'store')->name('quotes.store');
            Route::patch('/quotes/{quote}', 'update')->middleware('can:update-quote,quote')->name('quotes.update');
            Route::delete('/quotes/{quote}', 'destroy')->middleware('can:update-quote,quote')->name('quotes.destroy');
            Route::get('/quotes/{quote}', 'show')->middleware('can:update-quote,quote')->name('quote.show');
        });

        Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');

        Route::controller(UserController::class)->group(function () {
            Route::get('/user', 'index')->name('user.index');
            Route::patch('/user', 'update')->name('user.update');
            Route::patch('/user-email-update', 'updateEmail')->name('user.update-email');
        });

        Route::controller(LikeController::class)->group(function () {
            Route::post('/likes', 'store')->name('like.store');
            Route::delete('/likes/{like}', 'destroy')->middleware('can:delete-like,like')->name('like.destroy');
        });

        Route::controller(CommentController::class)->group(function () {
            Route::post('/comments', 'store')->name('comment.store');
            Route::delete('/comments/{comment}', 'destroy')->middleware('can:delete-comment,comment')->name('comment.destroy');
        });




        Route::controller(NotificationController::class)->group(function () {
            Route::get('notifications', 'index')->name('notiification.index');
            Route::patch('notifications', 'update')->name('notiification.update');
        });

    }
);
