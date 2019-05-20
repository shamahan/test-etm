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

Route::get('/companies', 'CompanyController@index');
Route::get('/companies/{id}', 'CompanyController@get');
Route::get('/companies/{id}/users', 'CompanyController@getusers');
Route::post('/companies/create', 'CompanyController@create');
Route::post('/companies/update/{id}', 'CompanyController@update');
Route::delete('/companies/delete/{id}', 'CompanyController@delete');

Route::get('/users', 'UserController@index');
Route::get('/users/{id}', 'UserController@get');
Route::get('/users/{id}/companies', 'UserController@getcompanies');
Route::post('/users/create', 'UserController@create');
Route::post('/users/update/{id}', 'UserController@update');
Route::delete('/users/delete/{id}', 'UserController@delete');

Route::post('/companies/{id}/user/{uid}', 'CompanyController@adduser');
Route::delete('/companies/{id}/user/{uid}', 'CompanyController@removeuser');
