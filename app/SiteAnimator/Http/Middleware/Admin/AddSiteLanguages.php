<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       AddSiteLanguages.php
        function:   
                    
        Last revision: 10-03-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Admin;

use Closure;
use App\Common\Base\BaseClass;
use App\Common\Models\Languages;

class AddSiteLanguages extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE SiteAnimator admin AddSiteLanguages' );

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
        $request->attributes->set( 'siteDefaultLanguageId', $defaultLanguageId );
        
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
