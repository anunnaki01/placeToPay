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

Route::get('/home', function () {
    return redirect()->route('transactions');
});

Auth::routes();
Route::get('/transactions','PseController@transactions')->name('transactions');
Route::get('/pse','PseController@Index')->name('payment');
Route::get('/reviewTransactions','ReviewTransactions@Index')->name('reviewTransactions');
Route::get('/cronReviewTransactions','ReviewTransactions@process')->name('CronReviewTransactions');
Route::post('/pse/createTransaction', 'PseController@createTransaction');
Route::get('/pse/transactionInformation', 'PseController@transactionInformation');
Route::get('/pse/transaction/{id}', 'PseController@findTransactionInformation')->name('details.transaction');



