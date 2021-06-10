<?php

/**
 * Frontend Access Controllers
 * All route names are prefixed with 'frontend.auth'.
 */
Route::group(['namespace' => 'Auth', 'as' => 'auth.'], function () {

    /*
     * These routes require the user to be logged in
     */
    Route::group(['middleware' => 'auth'], function () {
        Route::get('logout', 'LoginController@logout')->name('logout');

        //For when admin is logged in as user from backend
        Route::get('logout-as', 'LoginController@logoutAs')->name('logout-as');
    });

    /*
     * These routes require no user to be logged in
     */
    Route::group(['middleware' => 'guest'], function () {
        // Authentication Routes
        Route::get('login', 'LoginController@loginForm')->name('login');
        Route::post('login', 'LoginController@login')->name('login');

        // Socialite Routes
        Route::get('login/{provider}', 'SocialLoginController@login')->name('social.login');

        // Registration Routes
        if (config('access.users.registration')) {
            Route::get('register', 'RegisterController@registerForm')->name('register');
             Route::get('vendor-register', 'RegisterController@vendorRegisterForm')->name('vendor.register');
            Route::post('register', 'RegisterController@register')->name('register');
            Route::get('verification/{confirmationCode}','VerificationController@verification');
            Route::get('send-verification-link/{confirmationCode}','VerificationController@sendVerificationLink');
        }

        // Confirm Account Routes
        Route::get('account/confirm/{token}', 'ConfirmAccountController@confirm')->name('account.confirm');
        Route::get('account/confirm/resend/{user}', 'ConfirmAccountController@sendConfirmationEmail')->name('account.confirm.resend');

        // forgot password Routes
        Route::get('forgot-password', 'ForgotPasswordController@forgotPasswordForm');
        Route::post('forgot-password', 'ForgotPasswordController@forgotPassword');

        Route::get('reset-password/{validateString}','ResetPasswordController@resetPasswordForm');
        Route::post('reset-password','ResetPasswordController@resetPassword');
    });
});
