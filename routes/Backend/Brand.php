<?php
/**
 * BrandManagement
 *
 */

    Route::group( ['namespace' => 'Brands'], function () {
        Route::resource('brands', 'BrandController');
        Route::get('brand/edit/{id}','BrandController@edit')->name('brand.edit');
        Route::patch('brand/update/{id}','BrandController@update')->name('brand.update');
        Route::delete('brand/delete/{id}','BrandController@destroy')->name('brand.delete');
        Route::get('update-brand-status/{id}/{status}','BrandController@updateStatus')->name('brand.update-brand-status');
    });
    
