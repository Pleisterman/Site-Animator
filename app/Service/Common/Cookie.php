<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Service/Common/Cookie.php
        function:   reads and saves cookies
 
        Last revision: 18-02-2019
 
*/

namespace App\Service\Common;

use App\Http\Base\BaseClass;
use Cookie as CookieController;

class Cookie extends BaseClass  {

    protected $debugOn = true;
    public function set( $request, $type, $name, $token, $expirationPeriod ){
        
        // debug info 
        $this->debug( 'Cookie set type: ' . $type . ' name: ' . $name . ' url: ' . $request->root() );
        
        // handle exceptions
        try {

            // create cookie name
            $cookieName = $name . '_' .$type . '_' . md5( $request->root() );
            
            // save cookie
            CookieController::queue( CookieController::make( $cookieName, 
                                                             $token, 
                                                             $expirationPeriod, 
                                                             false,          // path 
                                                             null,           // domain 
                                                             false,          // secure
                                                             true )          // http only 
                                                            );
            // save cookie
            
            // no errors
            return true;
            
        }
        catch( Exception $e ){
            
            // debug info
            $this->debug( 'AdminJsonWebToken save cookie error: ' . $e->getMessage() );
            
            // done
            return false;
            
        }
        // handle exceptions
        
    }            
    public function get( $request, $type, $name ){
        
        // debug info 
        $this->debug( 'Cookie get type: ' . $type . ' name: ' . $name . ' url: ' . $request->root() );
        
        // create cookie name
        $cookieName = $name . '_' .$type . '_' . md5( $request->root() );
        
        return CookieController::get( $cookieName );
    }
}