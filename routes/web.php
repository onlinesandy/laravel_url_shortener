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
    return view('welcome');
});

Route::get('/url-shortener', 'LinksController@index')->name('urlShortener');
Route::post('/url-shortener', 'LinksController@shorten')->name('shorten');
Route::get('/getUrls', 'LinksController@getUrls')->name('getUrls');
Route::get('/{link}', 'LinksController@fetchUrl')->name('fetchUrl');

