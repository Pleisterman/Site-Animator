<?php

/*
        @package    Pleisterman/Common
  
        file:       DebugServiceProvider.php
        function:   create singleton service Debugger
 
        Last revision: 10-01-2020
 
*/

namespace App\Common\Providers;

use Illuminate\Support\ServiceProvider;
use App\Common\Service\Debugger;

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
