<?php

Route::group( ['namespace' => 'Region','prefix' => 'region'], function () {
    Route::get('/', 'RegionController@index')->name('region.index');
    Route::get('add-region','RegionController@addRegion')->name('region.add');
    Route::post('save-region','RegionController@saveRegion')->name('region.save');
    Route::get('edit-region/{id}','RegionController@editRegion')->name('region.edit');
    Route::post('update-region/{id}','RegionController@updateRegion')->name('region.update');
    Route::delete('delete-region/{id}','RegionController@deleteRegion')->name('region.delete');
    Route::get('update-region-status/{id}/{status}','RegionController@updateStatus')->name('region.update-region-status');
});
    
