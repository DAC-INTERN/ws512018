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
use App\Http\Middleware\Predict_String;

Route::get('/', 'HomeController@index')->name('home.index');
Route::get('/search', 'HomeController@search')->name('home.search');
Route::get('exportExcel/{type}', 'HomeController@exportExcel');


