<?php

/*
        @package    Pleisterman/Common
  
        file:       TruncateBaseDirFromRoute.php
        function:   
                    
        Last revision: 22-01-2020
 
*/

namespace App\Common\Http\Middleware\Site;

use Closure;
use App\Common\Base\BaseClass;

class TruncateBaseDirFromRoute extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE common Site TruncateBaseDirFromRoute' );

        // request path
        $pathArray = explode( '/', $request->attributes->get( 'route' ) );

        // get request action
        $action = $request->route()->getAction();
        
        // get app code
        $appCode = $action['appCode'];
        
        // get base dir
        $baseDir = env( $appCode . '_BASE_DIR' );

        // debug info
        $this->debug( 'baseDir: ' . $baseDir );
            
        // base dir ! ''
        if( !empty( $baseDir ) ){
            
            // debug info
            $this->debug( 'remove baseDir' );
            
            // debug info
            $this->debug( 'path: ' . $request->attributes->get( 'route' ) );
            
            // explode base dir
            $baseDirArray = explode( '/', $baseDir );

            // truncate base dir
            $pathArray = array_slice( $pathArray, count( $baseDirArray ) );

            // set site route
            $request->attributes->set( 'route', implode( '/', $pathArray ) );

            // debug info
            $this->debug( 'new path: ' . implode( '/', $pathArray ) );

        } 
        // base dir ! ''
        
        // follow the flow
        return $next( $request );
        
    }
    
}
