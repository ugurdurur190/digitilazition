<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\MailController;

Route::get('/',[IndexController::class,'index']);


Route::group(['middleware' => 'admin.role'], function () {

    //admin: forms
    Route::get('forms/new','App\Http\Controllers\FormController@newForm');
    Route::get('forms/store','App\Http\Controllers\FormController@storeForm');
    Route::get('forms/edit/{id}','App\Http\Controllers\FormController@editForm');
    Route::get('forms/update/{id}','App\Http\Controllers\FormController@updateForm');
    Route::get('forms/delete/{id}','App\Http\Controllers\FormController@deleteForm');
    Route::get('forms/continues-projects/view/{id}','App\Http\Controllers\FormController@viewContinuesProjectForm');

    //admin: project form question and process
    Route::get('forms/question/store','App\Http\Controllers\FormController@storeQuestion');
    Route::get('forms/question/delete/{id}','App\Http\Controllers\FormController@deleteQuestion');
    Route::get('forms/process/store','App\Http\Controllers\FormController@storeProcess');
    Route::get('forms/process/delete/{id}','App\Http\Controllers\FormController@deleteProcess');

    //admin: projects
    Route::get('projects/delete/{id}','App\Http\Controllers\ProjectController@deleteProject');
    Route::get('projects/votes/questions/manage/{id}','App\Http\Controllers\ProjectController@manageVoteQuestions');
    Route::get('projects/votes/questions/remove/{id}','App\Http\Controllers\ProjectController@softDeleteVoteQuestion');
    Route::get('projects/votes/questions/restore/{id}','App\Http\Controllers\ProjectController@softRestoreVoteQuestion');
    Route::get('projects/votes/questions/store','App\Http\Controllers\ProjectController@storeVoteQuestion');
    Route::get('projects/votes/questions/manage/permission/{id}','App\Http\Controllers\ProjectController@allowPermissionProject');

    //admin: my-projects
    Route::get('my-projects/list','App\Http\Controllers\MyProjectController@listMyProject');
    Route::get('my-projects/view/{id}','App\Http\Controllers\MyProjectController@viewMyProject');
    Route::get('my-projects/question/store','App\Http\Controllers\MyProjectController@storeNewProjectQuestion');
    Route::get('my-projects/question/delete/{id}','App\Http\Controllers\MyProjectController@deleteProjectQuestion');
    Route::get('my-projects/process/store','App\Http\Controllers\MyProjectController@storeNewProjectProcess');
    Route::get('my-projects/process/delete/{id}','App\Http\Controllers\MyProjectController@deleteProjectProcess');
    Route::get('my-projects/edit/{id}','App\Http\Controllers\MyProjectController@editMyProject');

    //admin: users
    Route::get('users/store','App\Http\Controllers\UserController@storeUser');
    Route::get('users/new','App\Http\Controllers\UserController@newUser');
    Route::get('users/list','App\Http\Controllers\UserController@listUser');
    Route::get('users/delete/{id}','App\Http\Controllers\UserController@deleteUser');
    Route::get('users/edit/{id}','App\Http\Controllers\UserController@editUser');
    Route::get('users/update/{id}','App\Http\Controllers\UserController@updateUser');

    Route::get('units/store','App\Http\Controllers\UserController@storeUnit');

    Route::get('user-guide','App\Http\Controllers\IndexController@viewUserGuide');

});


//Admin and Unit Executive privileges
Route::group(['middleware' => 'admin.unitSubscriber.role'], function () {
    Route::get('projects/units/approval/{id}','App\Http\Controllers\ProjectController@unitApproval');
    Route::get('projects/units/approval/store/{id}','App\Http\Controllers\ProjectController@storeUnitApproval');
});


//properties of non-developer user type
Route::group(['middleware' => 'general.roles'], function () {

    Route::get('dashboard',[IndexController::class,'indexDashboard']);

    Route::get('forms/list','App\Http\Controllers\FormController@listForm');
    Route::get('forms/view/{id}','App\Http\Controllers\FormController@viewForm');

    Route::get('projects/list','App\Http\Controllers\ProjectController@listProject');
    Route::post('projects/store','App\Http\Controllers\ProjectController@storeProject');
    Route::get('projects/vote/{id}','App\Http\Controllers\ProjectController@voteProject');
    Route::get('projects/vote/store/{id}','App\Http\Controllers\ProjectController@storeVote');
    Route::get('projects/vote/update/{id}','App\Http\Controllers\ProjectController@updateVote');
    Route::get('projects/votes/reports/list','App\Http\Controllers\ProjectController@listVoteReport');
    Route::get('projects/votes/reports/view/{id}','App\Http\Controllers\ProjectController@viewVoteReport');
    Route::get('projects/todoes/teams/users/store/{id}','App\Http\Controllers\TodoController@storeUserToTeam');
    Route::get('projects/todoes/teams/users/delete/{id}','App\Http\Controllers\TodoController@deleteUserTeam');
    Route::get('projects/todoes/teams/users/authorize/{id}','App\Http\Controllers\TodoController@authorizeUser');
    Route::get('projects/todoes/teams/users/restrict/{id}','App\Http\Controllers\TodoController@restrictUser');

    Route::get('video','App\Http\Controllers\IndexController@viewVideo');
});


Route::get('projects/continues/list','App\Http\Controllers\ProjectController@listContiunesProject');
Route::get('projects/completed/list','App\Http\Controllers\ProjectController@listCompletedProject');
Route::get('projects/view/{id}','App\Http\Controllers\ProjectController@viewProject');
Route::get('projects/todoes/works/view/{id}','App\Http\Controllers\TodoController@viewWork');
Route::get('projects/todoes/new/{id}','App\Http\Controllers\TodoController@newTodo');
Route::get('projects/todoes/new/store/{id}','App\Http\Controllers\TodoController@storeTodo');
Route::get('projects/todoes/update/{id}','App\Http\Controllers\TodoController@updateTodo');
Route::get('projects/todoes/commits/store/{id}','App\Http\Controllers\TodoController@storeCommit');
Route::get('projects/todoes/teams/view/{id}','App\Http\Controllers\TodoController@viewTeam');



Route::get('users/operations/view/{id}','App\Http\Controllers\UserController@viewUserOperation');
Route::get('users/operations/update/{id}','App\Http\Controllers\UserController@updateUserOperation');

//sign in - sign up
Route::get('home','App\Http\Controllers\CustomAuthController@home');
Route::get('login', 'App\Http\Controllers\CustomAuthController@index')->name('login');
Route::post('custom-login', 'App\Http\Controllers\CustomAuthController@customLogin')->name('login.custom'); 
//Route::get('registration', 'App\Http\Controllers\CustomAuthController@registration')->name('register-user');
//Route::post('custom-registration', 'App\Http\Controllers\CustomAuthController@customRegistration')->name('register.custom'); 
Route::get('signout', 'App\Http\Controllers\CustomAuthController@signOut')->name('signout');

Route::get('login/google', 'App\Http\Controllers\CustomAuthController@redirectToGoogle');
Route::get('login/google/callback', 'App\Http\Controllers\CustomAuthController@handleGoogleCallback');
?>