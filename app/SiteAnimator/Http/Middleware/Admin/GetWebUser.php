<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       GetWebUser.php
        function:   
                    
        Last revision: 24-12-2019
 
*/

namespace App\SiteAnimator\Http\Middleware\Admin;

use Closure;
use App\Common\Models\Admin\Authentication\AdminUsers;
use App\Common\Base\BaseClass;

class GetWebUser extends BaseClass {
    
    protected $debugOn = true;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE SiteAnimator admin get web user' );

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
        $pathArray = explode( '/', $request->attributes->get( 'route' ) );
        
        // create user name
        $userName = '';
        
        // path exists
        if( count( $pathArray ) > 0 ){
            
            // get user name
            $userName = $pathArray[0];
        
        }
        // path exists

        
        // debug info
        $this->debug( 'user name : ' . $userName . 'from route: ' . rtrim( $request->path(), '/' ) );
        
        // return result
        return $userName;
        
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
