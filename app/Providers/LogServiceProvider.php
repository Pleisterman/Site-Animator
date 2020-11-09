<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Providers/LogServiceProvider.php
        function:   create singleton service Log
 
        Last revision: 01-02-2019
 
*/

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\Common\Log;

class LogServiceProvider extends ServiceProvider
{
    public function register( )
    {
        
        // create singleton
        $this->app->singleton( 'Log', function(){
            
            // done
            return new Log();
            
        });
        // create singleton
        
    }

}
