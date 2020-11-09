<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Providers/LoginErrorServiceProvider.php
        function:   create singleton service LoginError
 
        Last revision: 01-02-2019
 
*/

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\Common\LoginError;

class LoginErrorServiceProvider extends ServiceProvider
{
    public function register( )
    {
        
        // create singleton
        $this->app->singleton( 'LoginError', function(){
            
            // done
            return new LoginError();
            
        });
        // create singleton
        
    }

}
