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
    return view('index', [
        'pageName' => 'Home',
        'title' => 'Home',
    ]);
})->name('homepage');

Route::get('/home', function () {
    return view('welcome');
});

Route::group(['namespace' => 'Auth'], function() {
    Route::get('login', 'LoginController@index');
    Route::get('register', 'RegisterController@index');
});

Route::any('/test', 'TestController@test');

/*
 * list
 */
Route::any('/category', 'CategoryController@categoryList')->name('categorypage');
Route::any('/attribute', 'AttributeController@attributeList')->name('attributepage');
Route::any('/project', 'ProjectController@projectList')->name('projectpage');
Route::any('/task', 'TaskController@taskList')->name('taskpage');
Route::any('/mail', 'MailController@mailList')->name('mailpage');
Route::any('/batch', 'BatchController@batchList')->name('batchpage');
Route::any('/log', 'LogController@logList')->name('logpage');

/*
 * detail
 */
Route::any('/attribute/{id}', 'AttributeController@attributeDetail')->where('id', '[0-9]+');
Route::any('/category/{id}', 'CategoryController@categoryDetail')->where('id', '[0-9]+');
Route::any('/task/{id}', 'TaskController@taskDetail')->where('id', '[0-9]+');

/*
 * relation
 */
Route::any('/category/attributelist/{id}', 'CategoryController@categoryAttributeList')->where('id', '[0-9]+');

/*
 * add and update
 */
Route::any('/attribute/edit/{id?}', 'AttributeController@attributeEdit')->where('id', '[0-9]+');
Route::any('/category/edit/{id?}', 'CategoryController@categoryEdit')->where('id', '[0-9]+');
Route::any('/project/edit/{id?}', 'ProjectController@projectEdit')->where('id', '[0-9]+');
Route::any('/task/edit/{id?}', 'TaskController@taskEdit')->where('id', '[0-9]+');
Route::any('/mail/edit/{id?}', 'MailController@mailEdit')->where('id', '[0-9]+');
Route::any('/batch/edit/{id?}', 'BatchController@batchEdit')->where('id', '[0-9]+');

/*
 * validate
 */
Route::any('/attribute/validate', 'AttributeController@validateName');
Route::any('/category/validate', 'CategoryController@validateName');
Route::any('/project/validate', 'ProjectController@validateName');
Route::any('/mail/validate', 'MailController@validateMail');
Route::any('/batch/validate', 'batchController@validateName');

/*
 * data fill
 */
Route::any('/task/{type}/{id?}', 'TaskController@taskFill')->where('id', '[0-9]+');
Route::any('/batch/{type}/{id}', 'BatchController@batchDetail')->where('id', '[0-9]+');

