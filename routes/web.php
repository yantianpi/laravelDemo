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
Route::any('/log', 'LogController@logList')->name('logpage');

/*
 * detail
 */
Route::any('/attribute/{id}', 'AttributeController@attributeDetail')->where('id', '[0-9]+');


/*
 * add and update
 */
Route::any('/attribute/edit/{id?}', 'AttributeController@attributeEdit')->where('id', '[0-9]+');