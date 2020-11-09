<?php

/*
        @package    Pleisterman/Common
  
        file:       CreatePrepareLogin.php
        function:   
                    
        Last revision: 24-12-2019
 
*/

namespace App\Common\Http\Middleware\Admin\Authentication;

use Closure;
use App\Common\Base\BaseClass;
use App\Common\Admin\Authentication\PrepareLoginToken;
use App\Common\Admin\Authentication\PrepareLoginCookie;

class CreatePrepareLogin extends BaseClass {
    
    protected $debugOn = true;
    private $database = 'none';
    private $appCode = null;
    private $user = null;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common admin create prepare login' );

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

        // create prepare login token
        $prepareLoginToken = new PrepareLoginToken( $this->appCode, $this->database, $this->user );

        // create token
        $token = $prepareLoginToken->create( $request );
        
        // token created
        if( $token ){
            
            // create cookie
            $prepareLoginCookie = new PrepareLoginCookie( $this->appCode, $this->database, $this->user );
            
            // create cookie
            $cookie = $prepareLoginCookie->create( $request );
            
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
