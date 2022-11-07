<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/tasks-with-assignee', 'TaskController@findAllWithAssignees');
Route::post('/task', 'TaskController@save')->middleware('auth');
Route::put('/task/{taskId}', 'TaskController@update')->middleware('auth');
Route::delete('/task/{taskId}', 'TaskController@delete')->middleware('auth');
