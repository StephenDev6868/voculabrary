<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\GoogleController;
use App\Http\Controllers\Api\FacebookController;
use App\Http\Controllers\Api\AboutUsController;
use App\Http\Controllers\Api\ExamController;
use App\Http\Controllers\Api\QuestionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['namespace' => 'Api'], function () {

    Route::post('login-guest', [AuthController::class, 'loginGuest']);
    Route::post('login-apple', [AuthController::class, 'loginApple']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forget-password', [AuthController::class, 'forgetPassword']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('update-password', [AuthController::class, 'updatePassword']);

    Route::post('auth/google', [GoogleController::class, 'login']);
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('googleCallback');

    Route::post('auth/facebook', [FacebookController::class, 'login']);
    Route::get('auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback'])->name('facebookCallback');


    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('user', [UserController::class, 'index']);
        Route::post('user/update', [UserController::class, 'update']);
        Route::post('user/update-avatar', [UserController::class, 'updateAvatar']);
        Route::post('user/change-password', [UserController::class, 'changePassword']);
        Route::post('user/logout', [UserController::class, 'logout']);
        Route::post('user/suggestion', [UserController::class, 'suggestion']);
        Route::post('user/suggest-number', [UserController::class, 'suggestion']);
        Route::post('user/reset-suggest-number', [UserController::class, 'resetSuggestion']);

        Route::get('notification', [HomeController::class, 'notification']);
        Route::get('notification/{id}', [HomeController::class, 'detailNotification']);

        Route::get('about-us', [AboutUsController::class, 'index']);
        Route::post('feedback', [AboutUsController::class, 'feedbackUser']);


        Route::get('banner', [HomeController::class, 'getSlider']);

        Route::get('home', [HomeController::class, 'index']);
        Route::get('get-rank', [HomeController::class, 'getRank']);
        Route::get('exam/{id}', [ExamController::class, 'getList']);
        Route::get('question/{id}', [QuestionController::class, 'index']);
        Route::post('answer', [QuestionController::class , 'getAnswer']);
        Route::post('user/result', [QuestionController::class , 'result']);

//        Route::get('search-data', [ArticleController::class, 'search']);
//        Route::get('get-wallet', [HomeController::class, 'getWallet']);
//        Route::get('get-using-data', [HomeController::class, 'getMyData']);
//        Route::post('user-deposit', [UserController::class, 'deposit']);
//        Route::post('transfer-money', [UserController::class, 'deposit']);
//        Route::get('category', [ArticleController::class, 'getListCategory']);
//        Route::get('get-data-by-category', [ArticleController::class, 'getDataByCategoryId']);
//        Route::get('show/{id}', [ArticleController::class, 'show']);
//        Route::post('register-service', [ArticleController::class, 'registerService']);
    });
});
