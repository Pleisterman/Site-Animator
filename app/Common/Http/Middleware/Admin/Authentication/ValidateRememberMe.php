<?php

/*
        @package    Pleisterman/Common
  
        file:       ValidateRememberMe.php
        function:   
                    
        Last revision: 24-12-2019
 
*/

namespace App\Common\Http\Middleware\Admin\Authentication;

use Closure;
use App\Common\Base\BaseClass;
use App\Common\Admin\Authentication\RememberMeToken;
use App\Common\Admin\Authentication\RememberMeCookie;
use App\Common\Admin\Authentication\JsonWebToken;
use App\Common\Admin\Authentication\PageToken;
use App\Common\Models\Admin\Authentication\AdminIps;

class ValidateRememberMe extends BaseClass {
    
    protected $debugOn = true;
    private $database = 'none';
    private $appCode = null;
    private $user = null;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common admin validate remember me' );

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

        // get user options
        $userOptions = $request->attributes->get( 'adminUserOptions' );
        
        // create remember me
        $rememberMe = $userOptions['rememberMe'] == 'true' ? true : false;
        
        // debug info
        $this->debug( 'user options remember me: ' . $rememberMe );

        // get token
        $token = $request->input('adminToken');

        // token exists
        if( $token ){

            // validate
            if( $this->validate( $request, $token ) ){
                
                // refresh json web token
                $jsonWebTokenId = $this->refreshJsonWebToken( $request );

                // reset ip strikes
                $this->resetIpStrikes( $request );
                
                // create page token
                $pageToken = new PageToken( $this->appCode, $this->database, $this->user );

                // creatw page token
                $token = $pageToken->createToken( $request, $jsonWebTokenId );

                // add token to request
                $request->attributes->set( 'adminToken', $token );

                // add user name to request
                $request->attributes->set( 'adminUserName', $this->user->name );

            }
            // validate
            
        }
        // remember me

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
        
        // ! validate json web token
        if( !$this->validateJsonWebToken( $request ) ){
            
            // ! valid
            return false;
            
        }
        // ! validate json web token
        
        // valid
        return true;
        
    }
    private function validateToken( $request, $token ){
        
        // create rememberMe token
        $rememberMeToken = new RememberMeToken( $this->appCode, $this->database, $this->user );

        // ! validate token
        if( !$rememberMeToken->validate( $request, $token ) ){
        
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
        
        // create rememberMe cookie
        $rememberMeCookie = new RememberMeCookie( $this->appCode, $this->database, $this->user );

        // ! validate cookie
        if( !$rememberMeCookie->validate( $request ) ){

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
    private function validateJsonWebToken( $request ){
        
        // create json web token token
        $jsonWebToken = new JsonWebToken( $this->appCode, $this->database, $this->user );

        // ! validate token
        if( !$jsonWebToken->validate( $request ) ){
        
            // debug
            $this->debug( 'json web token invalid' );        
            
            // ! valid
            return false;
            
        }    
        // validate token
            
        // debug
        $this->debug( 'json web token valid' );        
        
        // valid
        return true;
    
    }
    private function refreshJsonWebToken( $request ){
        
        // create json web token token
        $jsonWebToken = new JsonWebToken( $this->appCode, $this->database, $this->user );

        // refresh
        return $jsonWebToken->refresh( $request );
        
    }
    private function resetIpStrikes( $request ){
        
        // debug
        $this->debug( 'resetIpStrikes' );

        // get ip
        $ip = $request->attributes->get( 'adminIp' );
        
        // get ip
        $ipRow = AdminIps::on( $this->database )
                           ->where( 'id', $ip->id )
                           ->first();
        // get ip

        // ip row found
        if( $ipRow ){
        
            // reset strikes
            $ipRow->strikes = 0;
            
            // reset blocked
            $ipRow->blocked = false;
            
            // get date time
            $now = new \DateTime( 'now' );            

            // create update at
            $updatedAt = $now->format( 'Y-m-d H:i:s' );

            // set updated at
            $ipRow->updated_at = $updatedAt;

            // save ip
            $ipRow->save();
            
        }
        // ip found
        

    }
    
}
