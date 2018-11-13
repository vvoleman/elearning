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
Route::get('/activate/{key}','AccountController@getActivateAccount')->name('account.activate');
Route::post('/activate','AccountController@postActivateAccount')->name('account.saveActivation');
Route::get('/add','AccountController@getAddStudents')->middleware('hasRole:teacher,admin')->name('account.showAddUsers');
Route::middleware("hasRole:admin")->group(function(){
    Route::get('/accounts','AccountController@getAccountsListAdmin')->name('admin.accounts');
    Route::get('/accounts/edit/{id}','AccountController@getEditAccountAdmin')->where('id', '[0-9]+')->name('admin.editAccount');
    Route::post('/accounts','AccountController@postEditAccountAdmin')->name('admin.saveEditAccount');
});
Route::middleware("hasRole:teacher,admin")->group(function (){
    Route::get('/add','AccountController@getAddStudents')->name('account.showAddUsers');
    Route::post('/add','AccountController@postAddSingleStudent')->name('account.addSingleStudent');
    Route::post('/adds','AccountController@postAddStudents')->name('account.addStudents');
});

?>
