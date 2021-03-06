<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Providers/ApiErrorServiceProvider.php
        function:   create singleton service ApiError
 
        Last revision: 06-03-2019
 
*/

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\Common\WebError;

class WebErrorServiceProvider extends ServiceProvider
{
    public function register( )
    {
        
        // create singleton
        $this->app->singleton( 'WebError', function(){
            
            // done
            return new WebError();
            
        });
        // create singleton
        
    }

}
