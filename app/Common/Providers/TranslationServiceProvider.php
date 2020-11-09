<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Providers/DebugServiceProvider.php
        function:   create singleton service AdminTranslator
 
        Last revision: 01-02-2019
 
*/

namespace App\Common\Providers;

use Illuminate\Support\ServiceProvider;
use App\Common\Service\Translator;

class TranslationServiceProvider extends ServiceProvider
{
    public function register( )
    {
        
        // create singleton
        $this->app->singleton( 'Translator', function(){
            
            $request = $this->app->request;
            
            // done
            return new Translator( $request );
            
        });
        // create singleton
        
    }

}
