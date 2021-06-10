<?php

Route::group( ['namespace' => 'Event','prefix' => 'event'], function () {
    Route::get('/', 'EventController@index')->name('event.index');
    Route::get('add-event','EventController@addEvent')->name('event.add');
    Route::post('save-event','EventController@saveEvent')->name('event.save');
    Route::get('edit-event/{id}','EventController@editEvent')->name('event.edit');
    Route::post('update-event/{id}','EventController@updateEvent')->name('event.update');
    Route::delete('delete-event/{id}','EventController@deleteEvent')->name('event.delete');
});
    
