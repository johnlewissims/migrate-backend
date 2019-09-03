<?php

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::get('/user', 'AuthController@user');
Route::post('/logout', 'AuthController@logout');


Route::group(['prefix' => 'videos'], function(){
  Route::post('/', 'VideoController@store')->middleware('auth:api');
});
