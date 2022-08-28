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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function () {
    return view('test');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*Route::get('/contacts', function () {
    return view('contacts.index');
});*/
Route::get('contacts', 'ContactsController@index');

Route::resource('ajax-contacts', 'ContactsController');

Route::prefix('/books')->group(function(){
    Route::get('index' , [
        'as' => 'index',
        'uses' => 'BooksController@index'
    ]);
    Route::get('create', 'BooksController@create');
    Route::get('edit/{id}   ', 'BooksController@edit');
    Route::get('delete/{id}   ', 'BooksController@destroy');
    Route::post('store', 'BooksController@store');
});