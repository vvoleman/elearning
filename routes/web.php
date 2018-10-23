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

Route::get('/', 'HomeController@getIndex')->name('index');
Route::get('/about', 'HomeController@getAbout')->name('about');

Route::get('/login','LoginController@getLogin')->name('login.login');
Route::post('/login','LoginController@verifyLogin')->name('login.verifyLogin');
Route::get('/logout','LoginController@getLogout')->middleware('auth')->name('login.logout');

Route::get('/dashboard','AccountController@getDashboard')->middleware('auth')->name('account.dashboard');

Route::get('/accounts','AccountController@getAccountsListAdmin')->middleware('hasRole:admin')->name('admin.accounts');

?>
