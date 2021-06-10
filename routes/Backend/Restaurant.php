<?php

Route::group( ['namespace' => 'Restaurant','prefix' => 'restaurant'], function () {
    Route::get('/', 'RestaurantController@index')->name('restaurant.index');
    Route::get('approved/{id}','RestaurantController@approved')->name('restaurant.approved');
    Route::get('delete/{id}','RestaurantController@delete');
    Route::get('create','RestaurantController@restaurantCreate')->name('restaurant.create');
    Route::post('store','RestaurantController@restaurantStore')->name('restaurant.store');
    Route::get('restaurant-view/{id}','RestaurantController@restaurantView')->name('restaurant.view');
    Route::get('restaurant-edit/{id}','RestaurantController@restaurantEdit')->name('restaurant.edit');
    Route::PATCH('restaurant-update/{id}','RestaurantController@restaurantUpdate')->name('restaurant.update');

    Route::post('remove-image', 'RestaurantController@restaurantRemoveImage')->name('restaurant.remove-image');
    Route::post('remove-backgroundimage', 'RestaurantController@restaurantRemoveBackImage')->name('restaurant.remove-backgroundimage');
    Route::get('restaurant-state', 'RestaurantController@getBackendState')->name('restaurant.state');
        Route::get('restaurant-city', 'RestaurantController@getBackendCity')->name('restaurant.city');

});
    
