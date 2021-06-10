<?php

 Route::post('register','RegisterController@register');
 Route::post('login','AuthController@login');
 Route::post('social-login','AuthController@socialLogin');
 Route::get('logout','AuthController@logout');
 Route::post('update-profile','AuthController@updateProfile');
 Route::post('password/forget','ForgotPasswordController@sendResetLinkEmail');
 Route::post('change-password','ForgotPasswordController@changePassword');
 Route::post('category','ProductController@category');
 Route::post('region','ProductController@region');
 Route::post('diet','ProductController@diet');
 Route::post('brand','ProductController@brand');
 Route::get('country','ProductController@country');
 Route::post('state','ProductController@state');
 Route::post('city','ProductController@city');
 Route::get('allproducttype','ProductController@allProductType');
 Route::get('allcountrydata', 'ProductController@allCountryData');
  Route::post('product-detail','ProductController@prodctsDetail');
  
 Route::get('faq','FrontendController@faq');
 Route::get('getproduct','FrontendController@prodcts');

Route::get('home-data','FrontendController@homeData');


/* Address Controller */
 Route::post('address-list','AddressController@showAddress');
 Route::post('add-address','AddressController@saveAddress');
 Route::post('update-address','AddressController@updateAddress');
 Route::post('delete-address','AddressController@removeAddress');

// Account Information
Route::post('view-profile','AccountController@viewProfile');
Route::post('update-profile','AccountController@updateProfile');
Route::post('favorite','AccountController@favourite');
Route::post('wishlist','AccountController@wishList');


//Restaurant 
Route::post('restaurant-info','RestaurantsController@restsurantInformation');
Route::post('add-restaurant','RestaurantsController@addRestaurant');
Route::post('show-branch','RestaurantsController@showBranch');
Route::post('branch-list','RestaurantsController@branchList');
Route::post('add-branch','RestaurantsController@addBranch');
Route::post('update-branch','RestaurantsController@updateBranch');
Route::group(['namespace' => 'Vendor', 'prefix' => 'vendor','as' => 'vendor.'], function () {
  Route::post('register', 'RegisterController@vendorRegister');
  Route::post('login', 'AuthController@VendorLogin');
  Route::post('password/forget', 'ForgotPasswordController@VendorSendResetLinkEmail');
});

