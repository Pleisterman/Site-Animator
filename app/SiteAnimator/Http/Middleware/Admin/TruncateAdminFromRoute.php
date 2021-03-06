<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       TruncateAdminFromRoute.php
        function:   
                    
        Last revision: 24-01-2020
 
*/

namespace App\SiteAnimator\Http\Middleware\Admin;

use Closure;
use App\Common\Base\BaseClass;

class TruncateAdminFromRoute extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE SiteAnimator admin TruncateAdminFromRoute' );

        // get route
        $pathArray = explode( '/', $request->attributes->get( 'route' ) );
      
        // remove admin
        array_shift( $pathArray );
        
        // debug
        $this->debug( 'Route : ' . implode( '/', $pathArray ) . ' from route: ' . $request->path() );
        
        // set site route
        $request->attributes->set( 'route', implode( '/', $pathArray ) );
        
        // follow the flow
        return $next( $request );
        
    }
    
}
