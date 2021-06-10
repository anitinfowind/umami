<?php

Route::group( ['namespace' => 'VendorPayment','prefix' => 'vendorpayment'], function () {
    Route::get('/', 'VendorPaymentController@index')->name('vendorpayment.index');
     Route::get('view/{id}','VendorPaymentController@paymentView');
  //Route::get('/','payment-history/view/{id}','PaymentHistoryController@paymentView');
});
    
