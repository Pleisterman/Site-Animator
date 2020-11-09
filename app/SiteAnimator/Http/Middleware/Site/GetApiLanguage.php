<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       GetApiLanguage.php
        function:   
                    
        Last revision: 09-01-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Site;

use Closure;
use App\Common\Base\BaseClass;

class GetApiLanguage extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE SiteAnimator Site GetApiLanguage' );

            // get language id
            $languageId = $request->input( 'languageId' );
            
            // set selected language id
            $request->attributes->set( 'siteLanguageId', $languageId );
        
        // follow the flow
        return $next( $request );
        
    }
    
}
