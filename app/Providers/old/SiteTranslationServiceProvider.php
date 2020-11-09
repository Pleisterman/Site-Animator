<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Providers/DebugServiceProvider.php
        function:   create singleton service SiteTranslator
 
        Last revision: 01-02-2019
 
*/

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\Site\Translator;

class SiteTranslationServiceProvider extends ServiceProvider
{
    public function register( )
    {
        
        // create singleton
        $this->app->singleton( 'SiteTranslator', function(){
            
            // done
            return new Translator();
            
        });
        // create singleton
        
    }

}
