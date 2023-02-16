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

Route::get('login', 'AuthController@signIn');
Route::post('login', 'AuthController@login')->name('login');
Route::get('/', 'AdminController@index')->name('index');
Route::get('logout', 'AuthController@logout')->name('logout');

Route::group(['as' => 'manager-user.', 'prefix' => 'manager-user'], function () {
    Route::get('/', 'ManagerUserController@list')->name('index');
    Route::get('/{id}', 'ManagerUserController@detail')->name('detail');
    Route::post('/{id}', 'ManagerUserController@update')->name('update');
    Route::post('/update-user/{id}', 'ManagerUserController@updateUser')->name('updateUser');
});

Route::group(['as' => 'edit-email.', 'prefix' => 'edit-email'], function () {
    Route::get('/', 'EditEmailController@list')->name('index');
    Route::get('/{id}', 'EditEmailController@detail')->name('detail');
    Route::post('/{id}', 'EditEmailController@update')->name('update');
});

Route::group(['as' => 'receive-email.', 'prefix' => 'receive-email'], function () {
    Route::get('/', 'EditEmailController@receiveEmail')->name('index');
    Route::post('/', 'EditEmailController@updateReceiveEmail')->name('update');
});

Route::group(['as' => 'projects.', 'prefix' => 'projects'], function () {
    Route::get('/', 'ProjectController@index')->name('index');
    Route::get('{project}', 'ProjectController@detail')->name('detail');
    Route::get('is-contract/{project}', 'ProjectController@isProjectUserContract')->name('is-contract');
    Route::get('{project}/dedications', 'ProjectController@userDedications')->name('user.dedications');
    Route::post('{project}/status', 'ProjectController@changeStatus')->name('change.status');
    Route::post('{project}/status-recruiting', 'ProjectController@changeStatusAboutRecruiting')->name('change.status.recruiting');
    Route::post('{project}/delete', 'ProjectController@destroy')->name('destroy');
    Route::post('{project}/upload', 'ProjectController@uploadContract')->name('upload.contract');
    Route::post('{project}/{user}/kick-member', 'ProjectController@kickMember')->name('kick.member');
    Route::get('/edit/{id}', 'ProjectController@edit')->name('edit');
    Route::post('/update/{id}', 'ProjectController@update')->name('update');
    Route::post('/{project}/update-end-date', 'ProjectController@endDateUpdate')->name('update.end.date');
    Route::post('/update-project-user', 'ProjectController@projectUserUpdate')->name('project-user.update');
    Route::post('/delete-project-user', 'ProjectController@projectUserDelete')->name('project-user.delete');
});
