<?php
/**
 * CategoriesManagement
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'Categories'], function () {
        Route::resource('categories', 'CategoriesController');
        //For Datatable
        Route::post('categories/get', 'CategoriesTableController')->name('categories.get');
    });
    
});