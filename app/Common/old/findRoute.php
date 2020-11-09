<?php

/*
        @package    Pleisterman/Common
  
        file:       findRoute.php
        function:   
                    
        Last revision: 03-01-2020
 
*/

namespace App\Common\Http\Middleware\Site;

use Closure;
use App\Common\Base\BaseClass;

class findRoute extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common site findRoute' );

        // get route
        $route = $request->attributes->get( 'route' );   

        // find route with language
        $siteRoute = $this->findRouteWithLanguage( $request, $route );
        
        // follow the flow
        return $next( $request );
        
    }
    private function findRouteWithLanguage( $request, $route ) {
        
        
        
    }
    
}
