<?php
/**
 * Video
 *
 */

    Route::group( ['namespace' => 'Chef'], function () {
        Route::resource('chefs', 'ChefController');
        Route::get('chefs/view/{id}',  'ChefController@viewChef');
        //For Datatable
    });
    
