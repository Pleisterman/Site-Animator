<?php

/*
        @package    Pleisterman/Common
  
        file:       FindWebUser.php
        function:   
                    
        Last revision: 24-12-2019
 
*/

namespace App\Common\Http\Middleware\Admin;

use Closure;
use App\Common\Models\Admin\Authentication\AdminUsers;
use App\Common\Base\BaseClass;

class AddUserOptions extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common admin add user options' );

        // get request action
        $action = $request->route()->getAction();
       
        // get database
        $database = $action['database'];
        
        // get user
        $user = $request->attributes->get( 'adminUser' );
         
        // database / app code /  user ! exists
        if( !$database || !isset( $user ) ){
        
            // create route error
            $routeError = \App::make( 'RouteError' );
            
            // call error
            return $routeError->routeError( $request, 'values not set' );
            
        }
        // database / app code /  user ! exists
        
        // get user options
        $userOptions = AdminUsers::getOptions( $database, $user->id );
        
        // set ip
        $request->attributes->set( 'adminUserOptions', $userOptions );

        // follow the flow
        return $next( $request );
        
    }
    
}
