<?php

Route::group( ['namespace' => 'PaymentHistory','prefix' => 'paymenthistory'], function () {
    Route::get('/', 'PaymentHistoryController@index')->name('paymenthistory.index');
     Route::get('view/{id}','PaymentHistoryController@paymentView');
     Route::get('refund/{id}','PaymentHistoryController@refund');
     Route::get('label/{id}','PaymentHistoryController@label');
     Route::post('change-label','PaymentHistoryController@changelabel');
     Route::post('change-status','PaymentHistoryController@changestatus');
     Route::get('delete/{id}','PaymentHistoryController@delete');
     Route::get('details/{id}','PaymentHistoryController@details');
     Route::post('change-sales-deduction','PaymentHistoryController@changeSalesDeduction');
    Route::post('refund-payment','PaymentHistoryController@refund_payment');
  //Route::get('/','payment-history/view/{id}','PaymentHistoryController@paymentView');
});
    
