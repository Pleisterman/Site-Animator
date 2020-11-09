<?php

/*
        @package    Pleisterman/Common
  
        file:       ValidatePrepareLogin.php
        function:   
                    
        Last revision: 24-12-2019
 
*/

namespace App\Common\Http\Middleware\Admin\Authentication;

use Closure;
use App\Common\Base\BaseClass;
use App\Common\Admin\Authentication\PrepareLoginToken;
use App\Common\Admin\Authentication\PrepareLoginCookie;

class ValidatePrepareLogin extends BaseClass {
    
    protected $debugOn = true;
    private $database = 'none';
    private $appCode = null;
    private $user = null;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common admin validate prepare login' );

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

        // get token
        $token = $request->input('adminToken');

        // ! validate
        if( !$this->validate( $request, $token ) ){
        
            // create route error
            $routeError = \App::make( 'RouteError' );
            
            // call error
            return $routeError->AuthenticationError( $request );
            
        }
        // ! validate
        
        // follow the flow
        return $next( $request );
        
    }
    private function validate( $request, $token ){
        
        // debug
        $this->debug( 'validate' );        

        // ! validate token
        if( !$this->validateToken( $request, $token ) ){
            
            // ! valid
            return false;
            
        }
        // ! validate token
        
        // ! validate cookie
        if( !$this->validateCookie( $request ) ){
            
            // ! valid
            return false;
            
        }
        // ! validate cookie
        
        // valid
        return true;
        
    }
    private function validateToken( $request, $token ){
        
        // create prepare login token
        $prepareLoginToken = new PrepareLoginToken( $this->appCode, $this->database, $this->user );

        // ! validate token
        if( !$prepareLoginToken->validate( $request, $token ) ){
        
            // debug
            $this->debug( 'token invalid' );        
            
            // ! valid
            return false;
            
        }    
        // validate token
            
        // debug
        $this->debug( 'token valid' );        
        
        // valid
        return true;
        
    }            
    private function validateCookie( $request ){
        
        // create prepare login cookie
        $prepareLoginCookie = new PrepareLoginCookie( $this->appCode, $this->database, $this->user );

        // ! validate cookie
        if( !$prepareLoginCookie->validate( $request ) ){

            // debug
            $this->debug( 'cookie invalid' );        

            // ! valid
            return false;

        }
        // is valid
            
        // debug
        $this->debug( 'cookie valid' );        
    
        // valid
        return true;
        
    }
    
}
