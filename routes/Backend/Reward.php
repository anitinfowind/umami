<?php

/*
 * RewardManagement
 */
      Route::group( ['namespace' => 'Reward'], function () {
        Route::resource('reward', 'RewardController');
         Route::delete('reward-delete/{id}','RewardController@destroy')->name('reward.delete');
         Route::post('reward-update/{id}','RewardController@update')->name('reward.update');
        //For Datatable
       
     
    });