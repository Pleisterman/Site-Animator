<?php

/*
        @package    Pleisterman/Common
  
        file:       AddRouteVariables.php
        function:   
                    
        Last revision: 11-01-2020
 
*/

namespace App\Common\Http\Middleware;

use Closure;
use App\Http\Base\BaseClass;

class AddRouteVariables extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {
        
        // debug info
        $this->debug( 'middleware site AddRouteVariables ' );
        
        // debug info
        $this->debug( 'vars: ' . json_encode( $_POST ) );
        
        // set route variables
        $request->attributes->set( 'routeVariables', $_GET );
        
        // follow the flow
        return $next( $request );
                
    }
    
}
