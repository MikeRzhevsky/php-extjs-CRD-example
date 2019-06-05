<?php


Route::get('users/load_users',  'UserController@load');
Route::get('users/load_education',  'EducationController@load');
Route::get('users/load_city',  'CityController@load');
Route::post('users/create',     'UserController@create');
Route::post('users/delete', 'UserController@delete');

Route::get('/', function()
{
    return View::make('index_extjs');
});
