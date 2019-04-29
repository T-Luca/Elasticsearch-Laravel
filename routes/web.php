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

Route::get('/', 'ProductController@index');

Route::get('/products', 'ProductController@index')->name('products');

Route::get('/add', 'ProductController@create')->name('add-product');

Route::post('/store', 'ProductController@store')->name('store-product');

Route::post('/search', 'ProductController@search')->name('search-product');