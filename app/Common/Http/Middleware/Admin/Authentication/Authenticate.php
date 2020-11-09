<?php

/*
        @package    Pleisterman/Common
  
        file:       Authenticate.php
        function:   
                    
        Last revision: 30-12-2019
 
*/

namespace App\Common\Http\Middleware\Admin\Authentication;

use Closure;
use App\Common\Base\BaseClass;
use App\Common\Admin\Authentication\JsonWebToken;
use App\Common\Admin\Authentication\PageToken;
use App\Common\Models\Admin\Authentication\AdminIps;

class Authenticate extends BaseClass {
    
    protected $debugOn = true;
    private $database = 'none';
    private $appCode = null;
    private $user = null;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common admin authenticate credentials' );

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

        // create admin json web token
        $jsonWebToken = new JsonWebToken( $this->appCode, $this->database, $this->user );
        
        // create json web token
        $jsonWebTokenId = $jsonWebToken->validate( $request );
        
        // json web token id ! found
        if( !$jsonWebTokenId ){
        
            // Authentication failed
            return $this->AuthenticationFailed( $request );
            
        }
        // json web token id ! found        
        
        // create page token
        $pageToken = new PageToken( $this->appCode, $this->database, $this->user );
        
        // ! validate page token
        if( !$pageToken->validate( $request, $jsonWebTokenId ) ){
            
            // Authentication failed
            return $this->AuthenticationFailed( $request );
            
        }
        // ! validate page token
        
        // follow the flow
        return $next( $request );
        
    }
    private function AuthenticationFailed( $request ) {

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
            $ipRow->blocked = true;
            
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
        
        // create route error
        $routeError = \App::make( 'RouteError' );

        // call error
        return $routeError->ipBlockedError( $request );
        
    }
    
}
