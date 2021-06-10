<?php

/*
 * ProductManagement
 */
    Route::group( ['namespace' => 'Products'], function () {
        Route::resource('products', 'ProductsController');
        Route::delete('products/delete/{id}', 'ProductsController@destroy')->name('products.delete');
        Route::get('products/view/{id}', 'ProductsController@viewProduct')->name('products.view');
        Route::get('products/status/{id}/{status}', 'ProductsController@statusProduct')->name('products.status');

        Route::post('products/remove-image', 'ProductsController@productRemoveImage')->name('products.remove-image');
        //For Datatable
        Route::post('products/get', 'ProductsTableController')->name('products.get');
        Route::get('subcategory', 'ProductsController@subCategory');
        
    });

     //For product order
     Route::get('product-order', 'Products\ProductsController@productOrder')->name('product-order');
     Route::get('sortproductajax', 'Products\ProductsController@productOrderSave');

    Route::get('product_reviews', 'Products\ProductsController@product_reviews');
    Route::post('delete_review', 'Products\ProductsController@delete_review');
    Route::post('update_review', 'Products\ProductsController@update_review');
