<?php

/*
        @package    Pleisterman/Common
  
        file:       AddColors.php
        function:   
                    
        Last revision: 22-01-2020
 
*/

namespace App\Common\Http\Middleware\Admin;

use Closure;
use App\Common\Base\BaseClass;
use App\Common\Models\Admin\Colors;

class AddColors extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common admin add user colors' );

        // get request action
        $action = $request->route()->getAction();
       
        // get database
        $database = $action['database'];
        
        // get user options
        $userOptions = $request->attributes->get( 'adminUserOptions' );
         
        // database / userOptions ! exists
        if( !$database || !isset( $userOptions ) ){
        
            // create route error
            $routeError = \App::make( 'RouteError' );
            
            // call error
            return $routeError->routeError( $request, 'values not set' );
            
        }
        // database / userOptions ! exists
        
        // get colors
        $colors = Colors::getColors( $database, $userOptions['colorSchemeId'] );
        
        // set colors
        $request->attributes->set( 'adminColors', $colors );

        // follow the flow
        return $next( $request );
        
    }
    
}
