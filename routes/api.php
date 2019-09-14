<?php

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::get('/user', 'AuthController@user');
Route::post('/logout', 'AuthController@logout');

Route::group(['prefix' => 'videos'], function(){
  Route::post('/', 'VideoController@store')->middleware('auth:api');
  Route::get('/', 'VideoController@index')->middleware('auth:api');
  Route::get('/{video}', 'VideoController@show')->middleware('auth:api');
  Route::patch('/{video}', 'VideoController@patch')->middleware('auth:api');
  Route::delete('/{video}', 'VideoController@deleteVideo')->middleware('auth:api');
});

Route::group(['prefix' => 'assign'], function(){
  Route::post('/{video}', 'VideoController@assign')->middleware('auth:api');
  Route::get('/{video}', 'VideoController@list')->middleware('auth:api');
  Route::delete('/{video}', 'VideoController@delete')->middleware('auth:api');
});

Route::group(['prefix' => 'private'], function(){
  Route::get('/view/{video}', 'VideoController@view')->middleware('auth:api');
});

Route::group(['prefix' => 'watermark'], function(){
  Route::post('/', 'WatermarkController@store');
  Route::get('/{user}', 'WatermarkController@show')->middleware('auth:api');
  Route::delete('/{watermark}', 'WatermarkController@delete')->middleware('auth:api');
});



//Route::get('/{video}', 'VideoController@assign')->middleware('auth:api');
//Route::get('/videos/{id}/', 'VideoController@files')->middleware('auth:api');;
