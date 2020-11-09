<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Providers/MobileDetectServiceProvider.php
        function:   create singleton service MobileDetect
 
        Last revision: 01-02-2019
 
*/

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\Common\MobileDetect;

class MobileDetectServiceProvider extends ServiceProvider
{
    public function register( )
    {
        
        // create singleton
        $this->app->singleton( 'MobileDetect', function(){
            
            // done
            return new MobileDetect();
            
        });
        // create singleton
        
    }

}
