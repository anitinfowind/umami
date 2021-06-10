<?php

/*
 * VendorManagement
 */
      Route::group( ['namespace' => 'Vendor'], function () {
        Route::resource('vendors', 'VendorsController');
        //For Datatable
        Route::post('vendors/get', 'VendorsTableController')->name('vendors.get');
       Route::get('vendors/product/list','VendorsController@sellerProductlist')->name('vendors.product.list');
       Route::get('update-vendor-status/{id}/{status}','VendorsController@updateStatus')->name('vendors.update-vendor-status');
       Route::get('vendor/view/{id}','VendorsController@vendorView')->name('vendors.view');
    });