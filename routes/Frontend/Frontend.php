<?php

/**
 * Frontend Controllers
 * All route names are prefixed with '
 .'.
 */


//Route::middleware('cache.headers:public;max_age=2628000;etag')->group(function () {


Route::get('/', 'FrontendController@index')->name('index');




Route::get('dataget', 'FrontendController@getData');

Route::get('test/shippo', 'TestController@shippo');

Route::get('comming-soon', 'FrontendController@commingSoon')->name('commingSoon');
Route::get('about','FrontendController@aboutUs');
Route::get('mission','FrontendController@mission');
Route::get('feature','FrontendController@features');
Route::get('faq','FrontendController@faq');
Route::get('pages/{slug}', 'FrontendController@showPage')->name('pages.show');

/*Product*/
Route::get('products','ProductController@show');
Route::get('product-detail/{slug}','ProductController@productDetail');
Route::get('change-addon-price','ProductController@changeAddonPrice');


/* contact us*/
Route::get('contact-us','ContactController@contact');
Route::post('contact-us','ContactController@contactStore');

/* blog */
Route::get('blog','BlogController@show');
Route::get('blog/{slug}','BlogController@blogDetail');
Route::post('comment','BlogController@comment');
Route::post('remove-comment','BlogController@removeComment');

/*subscribe*/
Route::post('newsletter','NewsletterController@subscribe');

Route::get('order_email_notification','CheckoutController@order_email_notification');

/* event */
Route::get('event','EventController@show');
Route::get('event-detail/{slug}','EventController@eventDetail');

/* features */
Route::get('features','FeaturesController@show');

/* catering */
Route::get('catering','CateringController@show');
Route::get('all-chefs','CateringController@showAllChef');
Route::get('chef-detail/{slug}','CateringController@chefDetail');

/* corporate-gift */
Route::get('corporate-gift','CorporateGiftController@gift');

/* rewards */
Route::get('learn-about-rewards','FrontendController@rewards');

##### Restaurants ######
Route::group([ 'prefix' => 'restaurant'], function () {
    Route::get('/', 'RestaurantController@index');
});

Route::get('new-shops', 'RestaurantController@index');
Route::get('restaurant-detail/{slug}','RestaurantController@restaurantInfomation');

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 */
Route::get('pages/terms', 'FrontendController@showPage')->name('pages.show');
Route::get('page/tree-donate', 'FrontendController@donate');

### Videos  ###
Route::get('videos', 'VideoController@showVideo')->name('videos');
Route::get('video-detail/{slug}', 'VideoController@videoDetail')->name('video-detail');

### Subscription  ###
Route::get('subscription', 'SubscriptionController@index')->name('subscription');

### Company Detail ###
Route::get('user-detail/{slug}', 'CompanyController@companyInformation')->name('company');

## User Show Coupon ##
  Route::get('coupons', 'CouponController@couponList');


Route::group(['middleware' => 'auth'], function () {

    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');

        #### account #####
        Route::get('wish-list', 'AccountController@wishList')->name('wishlist');
        Route::get('account', 'AccountController@index')->name('account');
        Route::post('update-profile', 'AccountController@updateProfile')->name('update-profile');
        Route::post('change-password', 'AccountController@changePassword')->name('change-password');
        Route::post('favourite', 'AccountController@favourite')->name('favourite');
        Route::post('favouriteCheck', 'AccountController@favouriteCheck')->name('favourite');
        Route::post('remove-favorite', 'AccountController@removeFavorite')->name('remove-favorite');

        ## site Setting
        Route::post('vendor-payment', 'AccountController@paymentMethod')->name('vendor-payment');
        Route::post('email-setting', 'AccountController@updateEmail')->name('email-setting');
        ### Email- Notification
        Route::get('e-notification','AccountController@emailNotification');
        Route::post('email-status','AccountController@emailStatus');

        #### Address #####
        Route::get('address', 'AddressController@showAddress')->name('address');
        Route::get('add-address', 'AddressController@addressFrom')->name('add-address');
        Route::post('add-address', 'AddressController@saveAddress')->name('add-address');
        Route::get('state', 'AddressController@getState')->name('state');
        Route::get('city', 'AddressController@getCity')->name('city');
        Route::post('remove-address', 'AddressController@removeAddress')->name('remove-address');
        Route::post('primary-address', 'AddressController@primaryAddress')->name('primary-address');
        Route::get('edit-address/{addressId}', 'AddressController@editAddressFrom')->name('edit-address');
        Route::post('update-address', 'AddressController@updateAddress')->name('update-address');
    });



    //PaymentController
    Route::get('payment-history','PaymentController@paymentHistory');
    Route::get('report','PaymentController@report');
    Route::get('statement/view/{id}/{year}','PaymentController@statementView');
     Route::post('report_download','PaymentController@report_download');
     Route::get('payment-history/view/{id}','PaymentController@paymentView');
    
    Route::get('site-setting', 'SiteSettingController@index')->name('site-setting');

   


    ### Rating And Review ###
    Route::post('user/review', 'RatingController@userRating');
    Route::get('review', 'RatingController@userRatingList');
    Route::get('review-list', 'RatingController@ratingList');

    /* rewards */
    Route::get('rewards','FrontendController@rewardList');

    ###Notification  ###
    Route::get('notification', 'NotificationController@index')->name('notification');
    Route::get('notification/view/{id}', 'NotificationController@singleView')->name('notification.view');


    ### Chef  ####
    Route::get('chefs', 'ChefController@index')->name('chefs');
    Route::get('add-chef', 'ChefController@chefAdd')->name('add.chefs');
    Route::post('add-chef', 'ChefController@chefSave')->name('add.chefs');
    Route::get('edit-chef/{id}', 'ChefController@chefEdit')->name('edit.chefs');
    Route::post('update-chef', 'ChefController@chefUpdate')->name('update.chefs');
    Route::get('delete-chef/{id}', 'ChefController@chefDelete')->name('delete.chefs');

    ##### Product ######
    Route::group(['middleware' => 'productapprove'], function () {
        Route::get('product-manager', 'ProductController@productList')->name('product');
        Route::get('add-product', 'ProductController@productAdd')->name('add-product');
        Route::post('add-product', 'ProductController@productSave')->name('add-product');
        Route::get('edit-product/{slug}', 'ProductController@productEdit')->name('edit-product');
        Route::post('update-product', 'ProductController@updateProduct')->name('update-product');
        Route::post('delete-product','ProductController@deleteProduct')->name('delete-product');
        Route::post('product/remove-image','ProductController@removeImage');

        ##### RestaurantBranch ######
        Route::group([ 'prefix' => 'branch'], function () {
            Route::get('/', 'RestaurantBranchController@branch');
            Route::get('add-branch', 'RestaurantBranchController@addBranch');
            Route::post('save-branch', 'RestaurantBranchController@saveBranch');
            Route::get('edit-branch/{id}', 'RestaurantBranchController@editBranch');
            Route::post('update-branch', 'RestaurantBranchController@updateBranch');
            Route::post('delete-branch', 'RestaurantBranchController@deleteBranch');
            Route::get('view/{id}', 'RestaurantBranchController@viewBranch');
        });
    });

    //Coupon
    // Route::get('coupon', 'CouponController@index')->name('coupon');
    // Route::get('add-coupon', 'CouponController@addCoupon')->name('add.coupon');
    // Route::post('save-coupon', 'CouponController@saveCoupon')->name('save.coupon');
    // Route::get('edit-coupon/{id}', 'CouponController@editCoupon')->name('edit.coupon');
    // Route::get('update-coupon/{id}', 'CouponController@updateCoupon')->name('update.coupon');
    // Route::post('delete-coupon', 'CouponController@deleteCoupon')->name('delete.coupon');

    ##### Restaurants ######
    Route::group([ 'prefix' => 'restaurant'], function () {
        Route::get('info', 'RestaurantController@info');
        Route::match(['get', 'post'], 'shipping-info', 'RestaurantController@shipping_info');
        Route::post('save-restaurant', 'RestaurantController@saveRestaurant');
        Route::post('remove-image', 'RestaurantController@removeImage');
        Route::post('remove-backgroundimage', 'RestaurantController@backGroundImageDelete');
        Route::get('restaurant-state', 'RestaurantController@getState')->name('restaurant.state');
        Route::get('restaurant-city', 'RestaurantController@getCity')->name('restaurant.city');
    });
	
	## Add to Cart##
	//Route::get('cart', 'CheckoutController@cart');
    Route::post('cart/coupon', 'CheckoutController@couoponapply');
	Route::post('cart-store', 'CheckoutController@cartStore');
	Route::post('delete-cart-product', 'CheckoutController@deleteCartProduct');
	Route::post('increase-decrease-item', 'CheckoutController@increaseDecreaseItem');
	//Route::get('checkout', 'CheckoutController@checkout');
    Route::get('checkout1', 'CheckoutController@checkout1');
    /*Route::post('get_shipping_price', 'CheckoutController@get_shipping_price');
	Route::post('save-order', 'CheckoutController@saveOrder');
    Route::get('thank-you', 'CheckoutController@thank_you');*/
   
	
	Route::get('my-order', 'OrderController@myOrder');
	Route::get('order', 'OrderController@order');
  Route::get('order/view/{id}', 'OrderController@orderView');
	Route::post('order-status', 'OrderController@orderStatus');
	//Route::get('track-order/{id}', 'OrderController@trackOrder');
  Route::get('order-date/{date}', 'OrderController@datewiseOrder');
  Route::get('today-order-pickup', 'OrderController@today_order_pickup');
  Route::get('sales', 'SalesReportController@sales');
  Route::get('sales_payment', 'SalesReportController@sales_payment');


   ### Print Lable
  Route::get('order/print', 'OrderController@PrintOrderLable');

});

Route::get('cart', 'CheckoutController@cart');
Route::get('checkout', 'CheckoutController@checkout');
Route::post('get_shipping_price', 'CheckoutController@get_shipping_price');
Route::post('checkout_pay', 'CheckoutController@checkout_pay');
Route::post('save-order', 'CheckoutController@saveOrder');
Route::get('thank-you', 'CheckoutController@thank_you');
Route::get('track-order/{id}', 'OrderController@trackOrder');

 #Ajax
Route::post('/ajaxpost', 'AjaxController@ajaxpost');


//});



Route::get('quick_login/wjjdfg8439hg', 'FrontendController@quick_login');

Route::get('cron/upslabelgenerate', 'OrderController@upslabelgenerate');
Route::get('cron/sales_report_generate', 'OrderController@sales_report_generate');



Route::get('test/hidden_script', 'FrontendController@test_hidden_script');
Route::get('test/service_code', 'OrderController@test_service_code');
Route::get('test/upslabelgenerate', 'OrderController@test_upslabelgenerate');
Route::get('test/upslabelgenerate_restaurant', 'OrderController@test_upslabelgenerate_restaurant');
Route::get('test/upsrategenerate_restaurant', 'OrderController@test_upsrategenerate_restaurant');
Route::get('test/upsratetimeintransit_restaurant', 'OrderController@test_upsratetimeintransit_restaurant');
Route::get('test/upslabelgenerate_order', 'OrderController@upslabelgenerate_order');
Route::get('test/upstrack', 'OrderController@test_upstrack');
Route::get('test/order_email_notification', 'CheckoutController@test_order_email_notification');