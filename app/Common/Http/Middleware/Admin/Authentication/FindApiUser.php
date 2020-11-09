<?php

/*
        @package    Pleisterman/Common
  
        file:       FindApiUser.php
        function:   
                    
        Last revision: 24-12-2019
 
*/

namespace App\Common\Http\Middleware\Admin\Authentication;

use Closure;
use App\Common\Models\Admin\Authentication\AdminUsers;
use App\Common\Base\BaseClass;

class FindApiUser extends BaseClass {
    
    protected $debugOn = true;
    private $database = 'none';
    private $appCode = null;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common admin find api user' );

        // get request action
        $action = $request->route()->getAction();
        
        // get database
        $this->database = isset( $action['database'] ) ? $action['database'] : false;
        
        // get app code
        $this->appCode = isset( $action['appCode'] ) ? $action['appCode']: false;

        // get uid
        $this->uid = $request->input('adminUid');

        // database / app code /  user ! exists
        if( !$this->database || !$this->appCode || !$this->uid ){
        
            // create route error
            $routeError = \App::make( 'RouteError' );
            
            // call error
            return $routeError->routeError( $request, 'values not set' );
            
        }
        // database / app code /  user ! exists        

        // get user
        $user = $this->getUser( );
        
        // user found / else
        if( $user ){
            
            // debug info
            $this->debug( 'User found: ' . $user->name );
            
        }
        else {
            
            // debug info
            $this->debug( 'User ! found ' );
            
            // create route error
            $routeError = \App::make( 'RouteError' );
            
            // call error
            return $routeError->AuthenticationError( $request, 'user not found' );
            
        }
        // user found / else
        
        // set user
        $request->attributes->set( 'adminUser', $user );

        // follow the flow
        return $next( $request );
        
    }
    private function getUser( ){
        
        // create query
        $query = AdminUsers::on( $this->database )
                             ->where( 'uid', $this->uid );

        // return first
        return $query->first();              
        
    }
    
}
