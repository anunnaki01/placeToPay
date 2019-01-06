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

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/pse','PseController@Index')->name('payment');
Route::post('/pse/createTransaction', 'PseController@createTransaction');
Route::get('/pse/transactionInformation', 'PseController@transactionInformation');
Route::get('/pse/findTransactionInformation/{id}', 'PseController@findTransactionInformation');



