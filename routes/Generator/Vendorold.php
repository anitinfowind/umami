<?php
/**
 * VendorManagement
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'Vendor'], function () {
        Route::resource('vendors', 'VendorsController');
        //For Datatable
        Route::post('vendors/get', 'VendorsTableController')->name('vendors.get');

         
    });
    
});