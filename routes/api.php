<?php

//User Routes
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::get('/user', 'AuthController@user');
Route::post('/logout', 'AuthController@logout');

//Videos
Route::group(['prefix' => 'videos'], function(){
  Route::post('/', 'VideoController@store');
  Route::get('/', 'VideoController@index')->middleware('auth:api');
  Route::get('/{video}', 'VideoController@show')->middleware('auth:api');
  //Update Video
  Route::post('/update/{video}', 'VideoController@patch')->middleware('auth:api');
  Route::post('/status/{video}', 'VideoController@status')->middleware('auth:api');
  Route::delete('/{video}', 'VideoController@deleteVideo')->middleware('auth:api');

  //Comments
  Route::get('/comments/{video}', 'CommentController@showComments')->middleware('auth:api');
  Route::post('/comments/{video}', 'CommentController@postComment')->middleware('auth:api');
  Route::delete('/comments/{comment}', 'CommentController@deleteComment')->middleware('auth:api');
});

//Assign Videos to Users
Route::group(['prefix' => 'assign'], function(){
  Route::post('/{video}', 'VideoController@assign')->middleware('auth:api');
  Route::get('/{video}', 'VideoController@list')->middleware('auth:api');
  Route::delete('/{video}', 'VideoController@delete')->middleware('auth:api');
});

//Previewing Videos Securely
Route::group(['prefix' => 'private'], function(){
  Route::get('/view/{video}', 'VideoController@view')->middleware('auth:api');
});

//Watermarks
Route::group(['prefix' => 'watermark'], function(){
  Route::post('/', 'WatermarkController@store')->middleware('auth:api');
  Route::get('/{user}', 'WatermarkController@show')->middleware('auth:api');
  Route::delete('/{watermark}', 'WatermarkController@delete')->middleware('auth:api');
});

//Listing Users
Route::group(['prefix' => 'users'], function(){
  Route::get('/', 'VideoController@users');
  Route::get('/{user}', 'VideoController@user')->middleware('auth:api');
});

//Associate Users
Route::post('/associate/{user}', 'AssociateUsers@associate');
Route::get('/sponsors/{user}', 'AssociateUsers@sponsors');



//Route::get('/{video}', 'VideoController@assign')->middleware('auth:api');
//Route::get('/videos/{id}/', 'VideoController@files')->middleware('auth:api');;
