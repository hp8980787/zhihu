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

Route::get('/', 'QuestionsController@index');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('questions','QuestionsController',[
    'names'=>'questions',
]);

Route::post('/upload-imgs','UploadController@upload');

Route::post('questions/{question}/answer','AnswersController@store')->name('answers.store');

Route::get('questions/{question}/follow','QuestionFollowController@follow')->name('questions.follow')->middleware('auth');

Route::get('messages','NotificationsController@index')->name('messages');

Route::get('notifications','NotificationsController@notifications')->name('notifications');
