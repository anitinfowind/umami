<?php

Route::get('sales_report','SalesReportController@index');
Route::get('sales_report_dates','SalesReportController@sales_report_dates');
Route::get('get_sales_report_payments','SalesReportController@get_sales_report_payments'); 
