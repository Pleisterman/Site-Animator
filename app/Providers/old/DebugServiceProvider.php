<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Providers/DebugServiceProvider.php
        function:   create singleton service Debugger
 
        Last revision: 01-02-2019
 
*/

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\Common\Debugger;

class DebugServiceProvider extends ServiceProvider
{
    public function register( )
    {
        
        // create singleton
        $this->app->singleton( 'Debugger', function(){
            
            $request = $this->app->request;
            
            // done
            return new Debugger( $request );
            
        });
        // create singleton
        
    }

}
