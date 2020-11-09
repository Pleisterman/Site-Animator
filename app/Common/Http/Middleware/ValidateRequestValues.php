<?php

/*
        @package    Pleisterman/Common
  
        file:       ValidateRequestValues.php
        function:   
                    
        Last revision: 23-12-2019
 
*/

namespace App\Common\Http\Middleware;

use Closure;
use App\Common\Base\BaseClass;

    class ValidateRequestValues extends BaseClass {
    
    protected $debugOn = true;
    private $ip = null;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common admin validateRequestValues' );

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
        
        // follow the flow
        return $next( $request );
        
    }
    
}
