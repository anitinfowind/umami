<?php

/*
 * CategoriesManagement
 */
   Route::group( ['namespace' => 'Categories','prefix' => 'categories'], function () {
        Route::resource('categories', 'CategoriesController');

          Route::get('order', 'CategoriesController@categoryOrder')->name('categories.order');
          Route::get('sortvideoajax', 'CategoriesController@categoryOrderSave')->name('categories.sortvideoajax');
        //For Datatable
        Route::post('categories/get', 'CategoriesTableController')->name('categories.get');
        Route::get('update-category-status/{id}/{status}','CategoriesController@updateStatus')->name('categories.update-category-status');
   });