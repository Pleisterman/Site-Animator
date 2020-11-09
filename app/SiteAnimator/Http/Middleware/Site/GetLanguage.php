<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       GetLanguage.php
        function:   
                    
        Last revision: 09-01-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Site;

use Closure;
use App\Common\Base\BaseClass;

class GetLanguage extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE SiteAnimator Site GetLanguage' );

        // request path
        $pathArray = explode( '/', $request->attributes->get( 'route' ) );
        
        // find language
        $routeLanguageId = $this->findRouteLanguageId( $request, $pathArray );
        
        // has more then 1 path part
        if( $routeLanguageId ){

            // set selected language id
            $request->attributes->set( 'siteLanguageId', $routeLanguageId );
            
            $this->debug( 'language found' );
            
            // truncate path
            array_splice( $pathArray, 0, 1 );

            // set site route
            $request->attributes->set( 'route', implode( '/', $pathArray ) );
            
        }
        else {
            
            // get default language id
            $defaultLanguageId = $request->attributes->get( 'siteDefaultLanguageId' );
            
            // set selected language id
            $request->attributes->set( 'siteLanguageId', $defaultLanguageId );
            
        }
        // has more then 1 path part
        
        // follow the flow
        return $next( $request );
        
    }
    private function findRouteLanguageId( $request, $pathArray ) {
        
        // has more then 1 path part
        if( count( $pathArray ) > 0 ){

            // get languages
            $languages = $request->attributes->get( 'siteLanguages' );
            
            // get first part off path as language candidate
            $languageCanditate = $pathArray[0];

            // loop over languages
            forEach( $languages as $language ) {

                // language candidate is abbreviation
                if( $languageCanditate == $language['abbreviation'] ){

                    // debug info
                    $this->debug( 'language found: ' . $languageCanditate );

                    // return language id
                    return $language['id'];
                    
                }
                // language candidate is abbreviation

            }
            // loop over languages        

        }
        // has more then 1 path part
        
        
        // language not found
        return false;
        
    }
    
}
