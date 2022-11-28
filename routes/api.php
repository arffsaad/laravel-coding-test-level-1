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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API V1 routes
Route::prefix('v1')->group(function () {
    Route::get('events', 'App\Http\Controllers\EventsController@index');
    Route::get('events/active-events', 'App\Http\Controllers\EventsController@activeEvents');
    Route::get('events/{id}', 'App\Http\Controllers\EventsController@showEvent');

    Route::post('events', 'App\Http\Controllers\EventsController@createEvent');

    Route::put('events/{id}', 'App\Http\Controllers\EventsController@putEvent');

    Route::patch('events/{id}', 'App\Http\Controllers\EventsController@patchEvent');

    Route::delete('events/{id}', 'App\Http\Controllers\EventsController@deleteEvent');
});