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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('show/users', 'SpeakerController@showCards');
    
	Route::get('speakers', 'SpeakerController@index');
	Route::get('speakers/add', 'SpeakerController@create');
	Route::post('speakers/add', 'SpeakerController@store');
	Route::get('speakers/edit/{id}', 'SpeakerController@edit');
    Route::post('speakers/edit/{id}', 'SpeakerController@update');
    //Route::get('speakers/deleteImage/{id}', 'SpeakerController@deleteImage');  
    Route::get('/speakers/delete/{id}', 'SpeakerController@destroy');  
    Route::resource('speakers', 'SpeakerController');
    Route::post('croppie', 'SpeakerController@croppie');

   //     Route::get('/link1', function ()    {
   //     // Uses Auth Middleware
   // });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});
