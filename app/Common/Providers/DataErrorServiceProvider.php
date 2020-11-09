<?php

/*
        @package    Pleisterman/Common
  
        file:       DataErrorServiceProvider.php
        function:   create singleton service DataError
 
        Last revision: 03-03-2020
 
*/

namespace App\Common\Providers;

use Illuminate\Support\ServiceProvider;
use App\Common\Service\DataError;

class DataErrorServiceProvider extends ServiceProvider
{
    public function register( )
    {
        
        // create singleton
        $this->app->singleton( 'DataError', function(){
            
            // done
            return new DataError();
            
        });
        // create singleton
        
    }

}
