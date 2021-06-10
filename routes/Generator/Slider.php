<?php
/**
 * HomeSlider
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'Slider'], function () {
        Route::resource('sliders', 'SlidersController');
        //For Datatable
        Route::post('sliders/get', 'SlidersTableController')->name('sliders.get');
        Route::get('update-slider-status/{id}/{status}','SlidersController@updateStatus')->name('sliders.update-slider-status');
    });
    
});