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

/* AJAX */
Route::middleware(['isAjax'])->group(function (){
    Route::post('/ajax/checkEmailExists/','AjaxController@postCheckExistingEmail')->middleware('auth');
    Route::get('/ajax/getMessages','MessageController@getMessagesByAjax')->middleware('auth');
    Route::post('/ajax/markMsgAsSeen','MessageController@postMarkAsSeen')->middleware('auth');
    Route::post('/ajax/postMessage','MessageController@postMessage')->middleware('auth');
    Route::get('/ajax/getUsersByName','AjaxController@getUsersByName')->middleware('auth');
    Route::get('/ajax/getUsersByIds','AjaxController@getUsersByIds');
});

/* LOGIN */
Route::get('/login','LoginController@getLogin')->name('login.login');
Route::post('/login','LoginController@verifyLogin')->name('login.verifyLogin');
Route::get('/logout','LoginController@getLogout')->middleware('auth')->name('login.logout');

/* ACCOUNTS */
Route::get('/activate/{key}','AccountController@getActivateAccount')->name('account.activate');                                     //Activation view
Route::post('/act','AccountController@postActivateAccount')->name('account.saveActivation');                                        //Activation (saving credentials)
Route::get('/settings','AccountController@getSettingsAccount')->middleware('auth')->name('account.settings');                       //Settings view
Route::post('/settings','AccountController@postSettingsAccount')->middleware('auth')->name('account.settings');                     //Save new acc settings
Route::get('/add','AccountController@getAddStudents')->middleware('hasRole:teacher,admin')->name('account.showAddUsers');           //Add view
Route::middleware("hasRole:admin")->group(function(){                                                                       //ADMIN
    Route::get('/accounts','AccountController@getAccountsListAdmin')->name('admin.accounts');                                       //List of accounts view
    Route::get('/accounts/edit/{id}','AccountController@getEditAccountAdmin')->where('id', '[0-9]+')->name('admin.editAccount');    //Edit acc's view
    Route::post('/accounts','AccountController@postEditAccountAdmin')->name('admin.saveEditAccount');                               //Saving editted acc
});
Route::middleware("hasRole:teacher,admin")->group(function (){                                                              //ADMIN,TEACHER
    Route::get('/add','AccountController@getAddStudents')->name('account.showAddUsers');                                            //Add user view
    Route::post('/add','AccountController@postAddSingleStudent')->name('account.addSingleStudent');                                 //Post single student
    Route::post('/adds','AccountController@postAddStudents')->name('account.addStudents');                                          //Post .csv with students
});

/* MESSAGES */
Route::middleware('auth')->group(function(){
    Route::get('/messages','MessageController@getMessenger')->name('messages.index');
    Route::post('/messages','MessageController@postReplyToGetMessenger')->name('messages.replies');
});

/* COURSES */
Route::middleware('auth')->group(function(){
    Route::get('/dashboard','CourseController@getDashboard')->name('course.dashboard');                           //Dashboard view
    Route::get('/course/{id}','CourseController@getCoursePage')->where('id', '[0-9]+')->name('course.course');
    Route::get('/course/new','CourseController@getNewCourse')->middleware('hasRole:teacher,admin')->name('course.newCourse');
});
?>
