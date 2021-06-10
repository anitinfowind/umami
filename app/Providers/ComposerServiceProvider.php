<?php

namespace App\Providers;

use App\Http\Composers\GlobalComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\Composers\GlobalSetting;
use App\Http\Composers\Categorys;
/**
 * Class ComposerServiceProvider.
 */
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * Global
         */
        View::composer(
            // This class binds the $logged_in_user variable to every view
            '*',
            GlobalComposer::class
        );

        // Frontend
        View::composer(
        // This class binds the $setting variable to every view
            '*',
            GlobalSetting::class
        );
          View::composer(
        // This class binds the $setting variable to every view
            '*',
            Categorys::class
        );


        /*
         * Backend
         */
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

     
}
