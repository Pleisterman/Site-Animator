<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Providers/ApiErrorServiceProvider.php
        function:   create singleton service ApiError
 
        Last revision: 06-03-2019
 
*/

namespace App\Common\Providers;

use Illuminate\Support\ServiceProvider;
use App\Common\Service\RouteError;

class RouteErrorServiceProvider extends ServiceProvider
{
    public function register( )
    {
        
        // create singleton
        $this->app->singleton( 'RouteError', function(){
            
            // done
            return new RouteError();
            
        });
        // create singleton
        
    }

}
