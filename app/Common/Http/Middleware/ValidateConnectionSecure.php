<?php

/*
        @package    Pleisterman/Common
  
        file:       ValidateConnectionSecure.php
        function:   
                    
        Last revision: 23-12-2019
 
*/

namespace App\Common\Http\Middleware;

use Closure;
use App\Common\Base\BaseClass;

    class ValidateConnectionSecure extends BaseClass {
    
    protected $debugOn = true;
    private $ip = null;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common admin ValidateConnectionSecure' );

        // get request action
        $action = $request->route()->getAction();
        
        // get database
        $database = isset( $action['database'] ) ? $action['database'] : false;
        
        // get app code
        $appCode = isset( $action['appCode'] ) ? $action['appCode']: false;

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
        
        // ! admin connection secure / else
        if( !env( $prefix . 'AUTHORISATION_SECURE_PROTOCOL' ) ){
            
            // debug info
            $this->debug( 'OVERRIDE SECURE' );
            
        }
        else if( !$request->secure() ){
            
            // create route error
            $routeError = \App::make( 'RouteError' );
            
            // call error
            return $routeError->routeError( $request, 'connectionInsecure' );
            
        }
        // ! admin connection secure / else
        
        // follow the flow
        return $next( $request );
        
    }
    
}
