<?php

Route::group( ['namespace' => 'Shippings','prefix' => 'shippings'], function () {
    Route::get('/', 'ShippingsController@index')->name('shippings.index');
    Route::get('shippingcharge', 'ShippingsController@shippingcharge')->name('shippings.shippingcharge');
     Route::get('commission', 'ShippingsController@shippingCommission')->name('shippings.commission');
     Route::post('addcommission', 'ShippingsController@shippingCommissionAdd')->name('shippings.addcommission');
    Route::post('charge-shippings','ShippingsController@shippingcalculate')->name('shippings.charge-shippings');
    Route::post('save-shippings','ShippingsController@saveShippings')->name('shippings.save');
    Route::get('edit-shippings/{id}','ShippingsController@editShippings')->name('shippings.edit');
    Route::post('update-shippings/{id}','ShippingsController@updateShippings')->name('shippings.update');



    Route::get('shippings-state', 'ShippingsController@getShippingState')->name('shippings.state');
    Route::get('shippings-city', 'ShippingsController@getShippingCity')->name('shippings.city');

    Route::get('shippings-state-from', 'ShippingsController@getShippingFromState')->name('shippings.state.from');
    Route::get('shippings-city-from', 'ShippingsController@getShippingFromCity')->name('shippings.city.from');
    ## Shipping Fees

     Route::get('freeshipping', 'ShippingsController@shippingFree')->name('shippings.freeshipping');
     Route::get('edit-shippingsfee/{id}','ShippingsController@editShippingsFee')->name('shippings.edit-shippingsfee');
    Route::post('update-shippings-fees/{id}','ShippingsController@updateShippingsFees')->name('shippings.update.fees');
});
    
