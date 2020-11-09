<?php

/*
        @package    Pleisterman/Common
  
        file:       ValidateCookiesEnabled.php
        function:   
                    
        Last revision: 23-12-2019
 
*/

namespace App\Common\Http\Middleware;

use Closure;
use Cookie;
use App\Common\Base\BaseClass;

    class ValidateCookiesEnabled extends BaseClass {
    
    protected $debugOn = true;
    private $ip = null;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common admin validateCookiesEnabled' );

        // get request action
        $action = $request->route()->getAction();
        
        // get database
        $database = isset( $action['database'] ) ? $action['database'] : false;
        
        // get app code
        $appCode = isset( $action['appCode'] ) ? $action['appCode']: false;

        // get is admin
        $isAdmin = isset( $action['isAdmin'] ) ? $action['isAdmin']: false;

        // debug info
        $this->debug( 'database: ' . $database );

        // debug info
        $this->debug( 'appCode: ' . $appCode );

        // values not set
        if( !$database || !$appCode ){
        
            // create route error
            $routeError = \App::make( 'RouteError' );
            
            // call error
            return $routeError->routeError( $request, 'values not set' );
            
        }
        // values not set
        
        // create prefix
        $prefix = isset( $action['appCode'] ) ? $action['appCode'] . '_' : 'COMMON_';
        
        // add admin / site
        $prefix .= isset( $action['isAdmin'] ) && $action['isAdmin'] ? 'ADMIN_' : 'SITE_';
        
        // get token
        $cookiesEnabled = Cookie::get( env( $prefix . 'AUTHORISATION_COOKIES_ENABLED_NAME' ) );
        
        // cookies enabled
        if( $cookiesEnabled != 'true' ){
            
            // create route errors service
            $routeError = \App::make( 'RouteError' );

            // return error
            return $routeError->cookiesDisabledError( $request );
            
        }
        // cookies enabled
        
        // follow the flow
        return $next( $request );
        
    }
    
}
