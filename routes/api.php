<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/calendar/create', 'CalendarController@create');
Route::post('/calendar', 'CalendarController@store');
Route::get('/calendar/show', 'CalendarController@show');
Route::get('/calendar/{id}/edit', 'CalendarController@edit');
Route::put('/calendar/{id}', 'CalendarController@update');
Route::delete('/calendar', 'CalendarController@destroy');
