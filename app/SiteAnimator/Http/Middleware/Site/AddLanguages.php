<?php

/*
        @package    Pleisterman/Common
  
        file:       AddLanguages.php
        function:   
                    
        Last revision: 24-12-2019
 
*/

namespace App\SiteAnimator\Http\Middleware\Site;

use Closure;
use App\Common\Base\BaseClass;
use App\Common\Models\Languages;

class AddLanguages extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Site AddLanguages' );

        // get request action
        $action = $request->route()->getAction();
        
        // get database
        $database = isset( $action['database'] ) ? $action['database'] : 'none';
        
        // get languages
        $languages = Languages::getLanguages( $database, false );
        
        // get default language id
        $defaultLanguageId = $this->getDefaultLanguageId( $languages );
                   
        // add languages to request
        $request->attributes->set( 'siteLanguages', $languages );
        
        // add default language id to request
        $request->attributes->set( 'DefaultLanguageId', $defaultLanguageId );
        
        // follow the flow
        return $next( $request );
        
    }
    private function getDefaultLanguageId( $languages ) {

        // loop over languages
        forEach( $languages as $language ) {

            // is default
            if( $language['isDefault'] ){
                
                // return result
                return $language['id'];
                
            }
        }    
        // loop over languages

    }
    
}
