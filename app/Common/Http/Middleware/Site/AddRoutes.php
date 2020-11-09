<?php

/*
        @package    Pleisterman/Common
  
        file:       AddRoutes.php
        function:   
                    
        Last revision: 03-01-2020
 
*/

namespace App\Common\Http\Middleware\Site;

use Closure;
use App\Common\Base\BaseClass;
use App\Common\Models\Site\Routes;

class AddRoutes extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common site AddRoutes' );

        // get request action
        $action = $request->route()->getAction();
        
        // get database
        $database = isset( $action['database'] ) ? $action['database'] : 'none';
        
        // get routes
        $routes = Routes::getRoutes( $database );
        
        // add routes to request
        $request->attributes->set( 'routes', $routes );
        
        // follow the flow
        return $next( $request );
        
    }
    
}
