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

Route::get('/', function () {
    return view('index');
})->name('homepage');

Route::get('/home', function () {
    return view('welcome');
});

Route::group(['namespace' => 'Auth'], function() {
    Route::get('login', 'LoginController@index');
    Route::get('register', 'RegisterController@index');
});

Route::any('/test', 'TestController@test');