<?php
/**
 * Video
 *
 */

    Route::group( ['namespace' => 'Video'], function () {
        Route::resource('videos', 'VideosController');
        //For Datatable
        Route::post('videos/get', 'VideosTableController')->name('videos.get');
    });
    
