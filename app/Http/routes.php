<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::controllers([
    'auth'=>'Auth\AuthController',
    'password'=>'Auth\PasswordController'
]);
Route::get('/', function () {
    return view('index')->with('title','دونیت کن');
});
Route::get('/home', function () {
    return view('index')->with('title','دونیت کن');
});
Route::group(['prefix'=>'admin','middleware'=>'admin'],function(){
    Route::resource('/category','CategoryController' , ['expect'=>'show']);
});
Route::post('/register','UserController@registerUser');

Route::get('/donate','DonateController@index');
route::post('/payment','DonateController@payment');
Route::post('/donate/check','DonateController@check');
Route::get('/see','DonateController@see');
