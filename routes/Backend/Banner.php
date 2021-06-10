<?php

Route::group( ['namespace' => 'Banner','prefix' => 'banner'], function () {
    Route::get('/', 'BannerController@index')->name('banner.index');
    Route::get('add-banner','BannerController@addBanner')->name('banner.add');
    Route::post('save-banner','BannerController@saveBanner')->name('banner.save');
    Route::get('edit-banner/{id}','BannerController@editBanner')->name('banner.edit');
    Route::post('update-banner/{id}','BannerController@updateBanner')->name('banner.update');
    Route::delete('delete-banner/{id}','BannerController@deleteBanner')->name('banner.delete');

    Route::get('/video', 'BannerController@video')->name('banner.video');
    Route::get('add-video','BannerController@addVideo')->name('banner.add-video');
    Route::post('save-video','BannerController@saveVideo')->name('banner.videosave');
    Route::get('edit-video/{id}','BannerController@editVideo')->name('banner.videoedit');
    Route::post('update-video/{id}','BannerController@updateVideo')->name('banner.videoupdate');
});
    
