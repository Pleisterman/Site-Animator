<?php

/*
        @package    Pleisterman/Common
  
        file:       ValidateCredentials.php
        function:   
                    
        Last revision: 28-12-2019
 
*/

namespace App\Common\Http\Middleware\Admin\Authentication;

use Closure;
use App\Common\Base\BaseClass;
use App\Common\Admin\Authentication\LoginName;
use App\Common\Admin\Authentication\Password;
use App\Common\Admin\Authentication\JsonWebToken;
use App\Common\Admin\Authentication\PageToken;
use App\Common\Models\Admin\Authentication\AdminIps;

class ValidateCredentials extends BaseClass {
    
    protected $debugOn = true;
    private $database = 'none';
    private $appCode = null;
    private $user = null;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common admin validate credentials' );

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

        // validate credentials
        return $this->validate( $request, $next );
        
    }
    private function validate( $request, Closure $next ) {

        // create validate password 
        $loginName = new LoginName( $this->appCode, $this->database, $this->user );
        
        // ! validate login name
        if( !$loginName->validate( $request ) ) { 
            
            // login failed
            return $this->loginFailed( $request, $next );
            
        }
        // ! validate login name
        
        // create validate password 
        $password = new Password( $this->appCode, $this->database, $this->user );

        // ! validate password
        if( !$password->validate( $request ) ) { 
            
            // login failed
            return $this->loginFailed( $request, $next );
            
        }
        // ! validate password
        
        // create admin json web token
        $jsonWebToken = new JsonWebToken( $this->appCode, $this->database, $this->user );
        
        // create json web token
        $jsonWebTokenId = $jsonWebToken->create( $request );
        
        // create page token
        $pageToken = new PageToken( $this->appCode, $this->database, $this->user );
        
        // creatw page token
        $token = $pageToken->createToken( $request, $jsonWebTokenId );
        
        // add token to request
        $request->attributes->set( 'adminToken', $token );
        
        // add user name to request
        $request->attributes->set( 'adminUserName', $this->user->name );
                
        // reset ip strikes
        $this->resetIpStrikes( $request );
                
        // follow the flow
        return $next( $request );
        
    }
    private function loginFailed( $request, Closure $next ) {

        // create delay
        $delay = rand( env( 'AUTHORISATION_ADMIN_LOGIN_FAILED_MINIMUM_DELAY' ), 
                       env( 'AUTHORISATION_ADMIN_LOGIN_FAILED_MAXIMUM_DELAY' ) );
        // create delay
        
        // delay
        usleep( $delay );        

        // strike ip
        $this->strikeIp( $request );
        
        // follow the flow
        return $next( $request );
        
    }
    private function strikeIp( $request ) {
    
        // get ip
        $ip = $request->attributes->get( 'adminIp' );
        
        // get ip
        $ipRow = AdminIps::on( $this->database )
                           ->where( 'id', $ip->id )
                           ->first();
        // get ip

        // ip row found
        if( $ipRow ){
        
            // block ip
            $ipRow->strikes += 1;
            
            // > max strikes
            if( $ipRow->strikes >= env( $this->appCode . '_ADMIN_AUTHORISATION_IP_MAXIMUM_STRIKES' ) ){

                // block ip
                $ipRow->blocked = true;

            }
            // > max strikes        
            
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
