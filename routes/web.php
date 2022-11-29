<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // if logged in, redirect to dashboard
    if (Auth::check()) {
        return redirect("/events");
    }
    else {
        return view('home');
    }
});

Route::middleware(['auth'])->group(function () {
    Route::get('home', 'App\Http\Controllers\EventsController@uiIndex')->name('home');

    // route group events
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', 'App\Http\Controllers\EventsController@uiIndex')->name('index');
        Route::get('/create', 'App\Http\Controllers\EventsController@uiCreate')->name('create');
        Route::get('/{id}/edit', 'App\Http\Controllers\EventsController@uiEdit')->name('edit');
        Route::get('/{id}', 'App\Http\Controllers\EventsController@uiView')->name('view'); 
        
        Route::post('/create', 'App\Http\Controllers\EventsController@uiStore')->name('store');
        Route::post('/{id}/edit', 'App\Http\Controllers\EventsController@uiSave')->name('save');
        Route::post('/{id}/delete', 'App\Http\Controllers\EventsController@uiDelete')->name('delete');
        
    });
});
