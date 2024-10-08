<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', 'AuthController@login');

Route::middleware('auth:api')->group(function () {
    Route::get('gifs', 'GiphyController@index');
    Route::get('gifs/{id}', 'GiphyController@show');
    Route::post('gifs', 'GiphyController@store');
});
