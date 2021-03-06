<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       AddIndexTranslations.php
        function:   
                    
        Last revision: 21-01-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Admin;

use Closure;
use App\Common\Base\BaseClass;

class AddIndexTranslations extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE SiteAnimator admin AddIndexTranslations' );

        // create translator
        $this->translator = \App::make( 'Translator' );
        
        // get index translations
        $translations = $this->translator->getTranslationsByType( 'index' );

        // set translations
        $request->attributes->set( 'adminTranslations', $translations );
        
        // follow the flow
        return $next( $request );
        
    }
    
}
