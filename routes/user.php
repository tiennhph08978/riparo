<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'check_user_active'], function () {
    Route::get('/', 'LandingPageController@index')->name('index');

    Route::group(['as' => 'auth.'], function () {
        Route::get('/login', 'AuthController@login')->name('login');
        Route::post('/login', 'AuthController@postLogin')->name('post.login');

        Route::get('/logout', 'AuthController@logout')->name('logout');

        Route::get('/register', 'AuthController@register')->name('register');
        Route::post('/register', 'AuthController@postRegister')->name('postRegister');

        Route::get('/forgot-password', 'AuthController@getForgotPassword')->name('get_forgot_password');
        Route::get('/forgot-password-link/{email}', 'AuthController@getForgotPasswordLink')->name('forgot_password_link');
        Route::post('/forgot-password', 'AuthController@forgotPassword')->name('forgot_password');

        Route::get('/change-forgot-password', 'AuthController@getViewPassword')->name('get_view_rest_password');
        Route::post('/change-forgot-password', 'AuthController@changeForgotPassword')->name('change_forgot_password');

        Route::post('/change-password', 'AuthController@updatePassword')->name('update_password');
    });

    Route::get('account/verify/{id}/{token}', 'AuthController@verifyAccount')->name('email.verify');

    Route::group(['as' => 'project.', 'prefix' => 'project'], function () {
        Route::get('/', 'ProjectController@list')->name('list');
        Route::get('/mobile', 'ProjectController@listMobile')->name('list.mobile');
        Route::get('/{project}-{title}', 'ProjectController@detail')->name('detail');
        Route::post('/{project}-{title}', 'ProjectController@postDetail')->name('post.detail');
        Route::post('/update-cost/{id}', 'ProjectController@updateCost')->name('update.cost');
        Route::delete('/delete-cost/{id}', 'ProjectController@deleteCost')->name('delete.cost');
        Route::post('/update-turnover/{id}', 'ProjectController@updateTurnover')->name('update.turnover');
        Route::delete('/delete-turnover/{id}', 'ProjectController@deleteTurnover')->name('delete.turnover');
        Route::post('/update-dedication-member/{id}', 'ProjectController@updateDedicationMember')->name('update.dedication-member');
        Route::post('/update-dedication-founder/{id}', 'ProjectController@updateDedicationFounder')->name('update.dedication-founder');
        Route::post('/update-dedication/{id}', 'ProjectController@updateDedication')->name('update.dedication');
        Route::delete('/delete-dedication/{id}', 'ProjectController@deleteDedication')->name('delete.dedication');
        Route::get('/list-data-dedication/{id}', 'ProjectController@listDedication')->name('dedication.list');
        Route::get('/project-user/{id}', 'ProjectController@projectUser')->name('project-user.detail');
        Route::post('/update-project-user/{id}', 'ProjectController@projectUserUpdate')->name('project-user.update');
        Route::post('/delete-project-user/{id}', 'ProjectController@projectUserDelete')->name('project-user.delete');
        Route::group(['middleware' => 'auth'], function () {
            Route::get('create', 'ProjectController@create')->name('create');
            Route::get('create/complete', 'ProjectController@complete')->name('complete');
            Route::post('create', 'ProjectController@store')->name('store');
            Route::get('/edit/{id}', 'ProjectController@edit')->name('edit');
            Route::post('/update/{id}', 'ProjectController@update')->name('update');
            Route::post('/recruiting/{id}', 'ProjectController@recruiting')->name('recruiting');
            Route::post('/legalization/{id}', 'ProjectController@legalization')->name('legalization');
        });
    });

    Route::group(['as' => 'my_page.', 'prefix' => 'my-page'], function () {
        Route::get('/', 'MyPageController@index')->name('index');
        Route::get('/edit', 'MyPageController@editPersonal')->name('edit_personal');
        Route::post('/update', 'MyPageController@updatePersonal')->name('update_personal');
        Route::get('/edit-password', 'MyPageController@editPassword')->name('edit_password');
        Route::post('/update-password', 'MyPageController@updatePassword')->name('update_password');
    });
});
