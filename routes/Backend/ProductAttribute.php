<?php

Route::group( ['namespace' => 'ProductAttribute','prefix' => 'productAttribute'], function () {
    Route::get('/', 'ProductAttributeController@index')->name('productAttribute.index');
    Route::get('add-product-attribute','ProductAttributeController@addProductAttribute')->name('productAttribute.add');
    Route::post('save-product-attribute','ProductAttributeController@saveProductAttribute')->name('productAttribute.save');
    Route::get('edit-product-attribute/{id}','ProductAttributeController@editProductAttribute')->name('productAttribute.edit');
    Route::post('update-product-attribute/{id}','ProductAttributeController@updateProductAttribute')->name('productAttribute.update');
    Route::delete('delete-product-attribute/{id}','ProductAttributeController@deleteProductAttribute')->name('productAttribute.delete');
    Route::get('update-product-attribute-status/{id}/{status}','ProductAttributeController@updateStatus')->name('productAttribute.update-product-attribute-status');
});
    
