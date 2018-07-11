<?php

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');
Route::get('me', 'AuthController@getMe');
Route::ApiResources([
    'users' => 'UserController',
    'questions' => 'QuestionController',
    'experiments' => 'ExperimentController',
    'messages' => 'MessageController',
]);

Route::get('experiment-user/{id}', 'ExperimentController@indexByUser');
Route::get('moods', 'SettingsController@getMoods');
Route::post('moods', 'SettingsController@setMoods');
Route::get('delay', 'SettingsController@getDelay');
Route::post('delay', 'SettingsController@setDelay');

Route::get('csv-download/{id}', 'CsvController@download');
