<?php

Route::group( ['namespace' => 'Diet','prefix' => 'diet'], function () {
    Route::get('/', 'DietController@index')->name('diet.index');
    Route::get('add-diet','DietController@addDiet')->name('diet.add');
    Route::post('save-diet','DietController@saveDiet')->name('diet.save');
    Route::get('edit-diet/{id}','DietController@editDiet')->name('diet.edit');
    Route::post('update-diet/{id}','DietController@updateDiet')->name('diet.update');
    Route::delete('delete-diet/{id}','DietController@deleteDiet')->name('diet.delete');
    Route::get('update-diet-status/{id}/{status}','DietController@updateStatus')->name('diet.update-diet-status');
});
    
