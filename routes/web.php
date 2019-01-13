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
    Route::middleware('auth')->group(function() {
        Route::post('/ajax/checkEmailExists/', 'AjaxController@postCheckExistingEmail');
        Route::get('/ajax/getMessages', 'MessageController@getMessagesByAjax');
        Route::post('/ajax/markMsgAsSeen', 'MessageController@postMarkAsSeen');
        Route::post('/ajax/postMessage', 'MessageController@postMessage');
        Route::get('/ajax/getUsersByName', 'AjaxController@getUsersByName');
        Route::get('/ajax/getUsersByIds', 'AjaxController@getUsersByIds');
        Route::get('/ajax/checkCourseSlug', 'AjaxController@getCheckCourseSlug');
    });
    Route::middleware('hasRole:teacher,admin')->group(function(){
        Route::post('/ajax/updateCourse','CourseController@ajaxUpdate');
        Route::post('/ajax/syncStudentsInGroup','GroupController@ajaxSyncStudentsInGroup');
        Route::get('/ajax/importStudents','GroupController@ajaxImportStudents');
        Route::get('/ajax/getStudentsByGroups','GroupController@ajaxStudentsByGroups');
    });

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
    Route::middleware('hasRole:teacher,admin')->group(function(){
        Route::get('/course/new','CourseController@getNewCourse')->name('course.newCourse');
        Route::post('/course/new','CourseController@postNewCourse')->name("course.postNewCourse");
        Route::get('/course/{slug}/edit','CourseController@getEditCourse')->name('course.editCourse')->where('slug', '[a-zA-Z0-9_]+');
        Route::get('/course/{slug}/edit/lectors','CourseController@getEditLectors')->name('course.editLectors')->where('slug', '[a-zA-Z0-9_]+');
        Route::get('/course/{slug}/edit/groups','CourseController@getEditGroups')->name('course.editGroups')->where('slug', '[a-zA-Z0-9_]+');
        Route::get('/course/{slug}/edit/modules','CourseController@getEditModules')->name('course.editModules')->where('slug', '[a-zA-Z0-9_]+');
        Route::post('/course/{slug}/edit/settings','CourseController@postEditSettings')->name('course.postSettings')->where('slug', '[a-zA-Z0-9_]+');
        Route::get('/course/{slug}/edit/settings','CourseController@getEditSettings')->name('course.editSettings')->where('slug', '[a-zA-Z0-9_]+');
    });
    Route::get('/course/{slug}','CourseController@getCoursePage')->where('slug', '[a-zA-Z0-9_]+')->name('course.course');
});

/* GROUPS */
Route::middleware('auth')->group(function(){
    Route::get('/group/new','GroupController@getNewGroup')->name('group.newGroup')->middleware('hasRole:teacher,admin');
    Route::post('/group/new','GroupController@postNewGroup')->name('group.postNewGroup')->middleware('hasRole:teacher,admin');
    Route::get('/group/{id}','GroupController@getGroupPage')->name('group.group')->where('id', '[a-zA-Z0-9_]+');
    Route::get('/group/{id}/editstudent','GroupController@getEditStudent')->name('group.editStudent')->where('id', '[a-zA-Z0-9_]+')->middleware('hasRole:teacher,admin');
});

/* MODULES */
Route::middleware('auth')->group(function(){
    //Route::get('/course/{slug}/modules','ModuleController@getModules')->name('module.getModules')->where('slug', '[a-zA-Z0-9_]+');
    Route::get('/course/{slug}/module/{order}','ModuleController@getModule')->name('module.module')->where('slug', '[a-zA-Z0-9_]+')->where('order','[0-9]+');
});
?>
