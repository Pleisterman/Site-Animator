<?php

/*
        @package    Pleisterman/Commmon
  
        file:       MobileDetectServiceProvider.php
        function:   create singleton service MobileDetect
 
        Last revision: 11-01-2020
 
*/

namespace App\Common\Providers;

use Illuminate\Support\ServiceProvider;
use App\Common\Service\MobileDetect;

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
