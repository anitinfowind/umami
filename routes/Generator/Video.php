<?php
/**
 * Video
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'Video'], function () {
        Route::resource('videos', 'VideosController');
        //For Datatable
        Route::post('videos/get', 'VideosTableController')->name('videos.get');
    });
    
});