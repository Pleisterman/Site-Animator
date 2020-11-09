<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Providers/CookieServiceProvider.php
        function:   create singleton service Cookie
 
        Last revision: 18-02-2019
 
*/

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\Common\Cookie;

class CookieServiceProvider extends ServiceProvider
{
    public function register( )
    {
        // create singleton
        $this->app->singleton( 'Cookie', function(){
            
            // create cookie
            return new Cookie();
            
        });
        // create singleton
    }

}
