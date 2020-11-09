<?php

/*
        @package    Pleisterman/Common
  
        file:       GetRoute.php
        function:   
                    
        Last revision: 03-01-2020
 
*/

namespace App\Common\Http\Middleware\Site;

use Closure;
use App\Common\Base\BaseClass;

class GetRoute extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common site GetRoute' );

        // is ajax / else
        if( $request->ajax() ){
            
            // debug info 
            $this->debug( 'api get route' );
            
            // get route
            $route = rtrim( $request->input( 'route' ), '/');

        }
        else {

            // get route
            $route = rtrim( $request->path(), '/' );

        }        
        // is ajax / else
        
        // debug
        $this->debug( 'Route route: ' . $route );
        
        // set site route
        $request->attributes->set( 'route', $route );        
        
        // follow the flow
        return $next( $request );
        
    }
    
        
}