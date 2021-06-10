<?php

Route::group( ['namespace' => 'ProductVariants'], function () {
    Route::get('/product-variants', 'ProductVariantsController@index')->name('productVariants.index');
    Route::get('add-product-variants','ProductVariantsController@addProductVariants')->name('productVariants.add');
    Route::post('save-product-variants','ProductVariantsController@saveProductVariants')->name('productVariants.save');
    Route::get('edit-product-variants/{id}','ProductVariantsController@editProductVariants')->name('productVariants.edit');
    Route::post('update-product-variants/{id}','ProductVariantsController@updateProductVariants')->name('productVariants.update');
    Route::delete('delete-product-variants/{id}','ProductVariantsController@deleteProductVariants')->name('productVariants.delete');
    Route::get('update-product-variants-status/{id}/{status}','ProductVariantsController@updateStatus')->name('productVariants.update-product-variants-status');
});
    
