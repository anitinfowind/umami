<?php

/**
 * All route names are prefixed with 'admin.'.
 */
Route::get('dashboard', 'DashboardController@index')->name('dashboard');
Route::post('get-permission', 'DashboardController@getPermissionByRole')->name('get.permission');

/*
 * Edit Profile
*/
Route::get('profile/edit', 'DashboardController@editProfile')->name('profile.edit');
Route::patch('profile/update', 'DashboardController@updateProfile')
    ->name('profile.update');

Route::get('commission','DashboardController@commission')->name('commission.index');
Route::get('commission/create','DashboardController@commissionCreate')->name('commission.create');
Route::post('commission/store','DashboardController@commissionStore')->name('commission.store');
Route::get('commission/edit/{id}','DashboardController@commissionEdit')->name('commission.edit');
Route::patch('commission/update/{id}','DashboardController@commissionUpdate')->name('commission.update');

Route::get('commission','DashboardController@commission')->name('commission.index');
Route::get('commission/create','DashboardController@commissionCreate')->name('commission.create');
Route::post('commission/store','DashboardController@commissionStore')->name('commission.store');
Route::get('commission/edit/{id}','DashboardController@commissionEdit')->name('commission.edit');

Route::get('subscriptions/feature','Subscription\SubscriptionsController@Feature')->name('subscriptions.feature');
Route::get('subscriptions/feature/create','Subscription\SubscriptionsController@FeatureCreate')->name('subscriptions.feature.create');
Route::post('subscriptions/feature/store','Subscription\SubscriptionsController@FeatureStore')->name('subscriptions.feature.store');
Route::get('subscriptions/feature/edit/{id}','Subscription\SubscriptionsController@FeatureEdit')->name('subscriptions.feature.edit');
Route::patch('subscriptions/feature/update/{id}','Subscription\SubscriptionsController@FeatureUpdate')->name('subscriptions.feature.update');
Route::delete('subscriptions/feature/delete/{id}','Subscription\SubscriptionsController@FeatureDelete')->name('subscriptions.feature.delete');


Route::get('newsletter','NewsLetterController@index')->name('newsletters.index');

Route::get('testimonials','TestimonialController@index');
Route::post('get_testimonial','TestimonialController@get_testimonial');
Route::post('set_testimonial','TestimonialController@set_testimonial');
Route::post('delete_testimonial','TestimonialController@delete_testimonial');

Route::get('notifications','NotificationsController@index');
Route::post('set_notification','NotificationsController@set_notification');