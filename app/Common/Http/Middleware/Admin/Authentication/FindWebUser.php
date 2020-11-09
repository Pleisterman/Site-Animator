<?php

/*
        @package    Pleisterman/Common
  
        file:       FindWebUser.php
        function:   
                    
        Last revision: 24-12-2019
 
*/

namespace App\Common\Http\Middleware\Admin\Authentication;

use Closure;
use App\Common\Models\Admin\Authentication\AdminUsers;
use App\Common\Base\BaseClass;

class FindWebUser extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common admin find web user' );

        // get user name from route 
        $userName = $this->getUserNameFromRoute( $request );
        
        // get user
        $user = $this->getUser( $request, $userName );
        
        // user found / else
        if( $user ){
            
            // debug info
            $this->debug( 'User found: ' . $user->name );
            
        }
        else {
            
            // debug info
            $this->debug( 'User ! found ' );
            
            // redirect to site
            return $this->redirectToSite( $request );
            
        }
        // user found / else
        
        // set user
        $request->attributes->set( 'adminUser', $user );

        // follow the flow
        return $next( $request );
        
    }
    private function getUserNameFromRoute( $request ){
        
        // get path array
        $pathArray = explode( '/', rtrim( $request->path(), '/' ) );
        
        // get user route 
        $userRoute = $pathArray[count( $pathArray ) - 1];
        
        // debug info
        $this->debug( 'user route: ' . $userRoute );
        
        // return result
        return $userRoute;
        
    }
    private function getUser( $request, $userName ){
        
        // get request action
        $action = $request->route()->getAction();
       
        // get database
        $database = isset( $action['database'] ) ? $action['database'] : 'none';
        
        // create query
        $query = AdminUsers::on( $database )
                             ->where( 'route', $userName );

        // return first
        return $query->first();              
        
    }
    private function redirectToSite( $request ){
        
        // get route error
        $routeError = \App::make( 'RouteError' );

        // call route error
        return $routeError->AuthenticationError( $request );
        
    }
    
}
