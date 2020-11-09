<?php

/*
        @package    Pleisterman/Common
  
        file:       CreateRememberMe.php
        function:   
                    
        Last revision: 24-12-2019
 
*/

namespace App\Common\Http\Middleware\Admin\Authentication;

use Closure;
use App\Common\Base\BaseClass;
use App\Common\Admin\Authentication\RememberMeToken;
use App\Common\Admin\Authentication\RememberMeCookie;

class CreateRememberMe extends BaseClass {
    
    protected $debugOn = true;
    private $database = 'none';
    private $appCode = null;
    private $user = null;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common admin create remember me' );

        // get request action
        $action = $request->route()->getAction();
       
        // get database
        $this->database = isset( $action['database'] ) ? $action['database'] : false;
        
        // get appa code
        $this->appCode = isset( $action['appCode'] ) ? $action['appCode']: false;

        // get user
        $this->user = $request->attributes->get( 'adminUser' );
         
        // database / app code /  user ! exists
        if( !$this->database || !$this->appCode || !isset( $this->user ) ){
        
            // create route error
            $routeError = \App::make( 'RouteError' );
            
            // call error
            return $routeError->routeError( $request, 'values not set' );
            
        }
        // database / app code /  user ! exists        
       
        // debug info
        $this->debug( 'add remember me' );

        // create token
        $token = $this->createToken( $request );

        // add token to request
        $request->attributes->set( 'adminToken', $token );
            
        // follow the flow
        return $next( $request );
        
    }
    private function createToken( $request ){
        
        // debug
        $this->debug( 'Create token' );        

        // create rememberMe token
        $rememberMeToken = new RememberMeToken( $this->appCode, $this->database, $this->user );

        // create token
        $token = $rememberMeToken->create( $request );
        
        // token created
        if( $token ){
            
            // create cookie
            $rememberMeCookie = new RememberMeCookie( $this->appCode, $this->database, $this->user );
            
            // create cookie
            $cookie = $rememberMeCookie->create( $request );
            
            // cookie created
            if( $cookie ){
                
                // return token
                return $token;
                
            }
            // cookie created
            
        }
        // token created
        
        // no token created
        return 'false';       
        
    }
    
}
