<?php

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

Route::prefix('admin')->group(function() {
    Route::get('login', 'LoginController@showLoginForm')->name('backend.show_login_form');
    Route::post('/login', 'LoginController@login')->name('backend.login');
    Route::post('/logout', 'LoginController@logout')->name('backend.logout');

    route::group(['middleware' => 'admin'], function () {
        Route::resource('role', 'RoleController');
        Route::get('/', 'HomeController@index')->name('backend.home');

        Route::resource('category', 'CategoryController');
        Route::post('category-update-status/{id}', 'CategoryController@updateStatus');
        Route::get('list-data-category', 'CategoryController@getListData');

        Route::resource('slider', 'SliderController');
        Route::post('slider-update-status/{id}', 'SliderController@updateStatus');

        Route::resource('exam', 'ExamController');
        Route::post('exam-update-status/{id}', 'ExamController@updateStatus');

        Route::resource('user', 'UserController');
        Route::post('user-update-status/{id}', 'UserController@updateStatus');

        Route::resource('notification', 'NotificationController');
        Route::post('notification-update-status/{id}', 'NotificationController@updateStatus');

        Route::resource('about-us', 'AboutUsController');
        Route::post('about-us-update-status/{id}', 'AboutUsController@updateStatus');

        Route::get('feedback', 'FeedbackController@index')->name('feedback.index');
        Route::get('feedback/{id}', 'FeedbackController@show')->name('feedback.show');
        Route::post('feedback/destroy/{id}', 'FeedbackController@destroy')->name('feedback.delete');
        Route::post('feedback/send-email/{id}', 'FeedbackController@sendEmail')->name('feedback.send_email');

        Route::resource('account', 'AccountController');
        Route::post('account-update-status/{id}', 'AccountController@updateStatus');

    });
});
