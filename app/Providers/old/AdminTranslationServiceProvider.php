<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Providers/DebugServiceProvider.php
        function:   create singleton service AdminTranslator
 
        Last revision: 01-02-2019
 
*/

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\Admin\Translator;

class AdminTranslationServiceProvider extends ServiceProvider
{
    public function register( )
    {
        
        // create singleton
        $this->app->singleton( 'AdminTranslator', function(){
            
            // done
            return new Translator();
            
        });
        // create singleton
        
    }

}
