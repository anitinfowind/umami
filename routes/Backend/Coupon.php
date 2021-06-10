<?php

Route::group( ['namespace' => 'Coupon','prefix' => 'coupon'], function () {
    Route::get('/', 'CouponController@index')->name('coupon.index');
    Route::get('add-coupon','CouponController@addCoupon')->name('coupon.add');
    Route::post('save-coupon','CouponController@saveCoupon')->name('coupon.save');
    Route::get('edit-coupon/{id}','CouponController@editCoupon')->name('coupon.edit');
    Route::post('update-coupon/{id}','CouponController@updateCoupon')->name('coupon.update');
    Route::delete('delete-coupon/{id}','CouponController@deleteCoupon')->name('coupon.delete');
});
    
