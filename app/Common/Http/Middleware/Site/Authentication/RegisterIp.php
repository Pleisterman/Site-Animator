<?php

/*
        @package    Pleisterman/Common
  
        file:       RegisterIp.php
        function:   
                    
        Last revision: 03-01-2020
 
*/

namespace App\Common\Http\Middleware\Site\Authentication;

use Closure;
use App\Common\Models\Site\Authentication\SiteIps;
use App\Common\Base\BaseClass;

class RegisterIp extends BaseClass {
    
    protected $debugOn = true;
    private $ip = null;
    private $appCode = null;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common site register ip' );

        // get request action
        $action = $request->route()->getAction();
       
        // get appa code
        $this->appCode = isset( $action['appCode'] ) ? $action['appCode']: false;
        
        // register ip
        $this->registerIp( $request );
        
        // ip blocked
        if( $this->ip->blocked ){
            
            // delay blocked
            $this->delayBlocked( );
            
        }
        // ip blocked
        
        // set ip
        $request->attributes->set( 'ip', $this->ip );

        // follow the flow
        return $next( $request );
        
    }
    private function registerIp( $request ){
        
        // get request action
        $action = $request->route()->getAction();
       
        // get database
        $database = isset( $action['database'] ) ? $action['database'] : 'none';
        
        // debug
        $this->debug( 'registerIp' );
        
        // get ip
        $this->ip = SiteIps::on( $database )
                             ->where( 'ip', $request->ip() )->get()->first();
        
        // ip not found
        if( !$this->ip ){
            
            // create new ip
            $this->ip = new SiteIps();
            $this->ip->setConnection( $database );
            // set columns
            $this->ip->ip = $request->ip();
            $this->ip->strikes = 0;
            $this->ip->blocked = false;
            
        }
        // ip not found
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );

        // set updated at
        $this->ip->updated_at = $updatedAt;
        
        // save ip
        $this->ip->save();
            
    }
    private function delayBlocked( ){
        
        // debug
        $this->debug( 'delayBlocked' );
        
        // get minimum delay
        $minimumDelay = env( $this->appCode . '_AUTHORISATION_SITE_IP_BLOCKED_MINIMUM_DELAY' );
        
        // no minimum
        $minimumDelay = $minimumDelay ? $minimumDelay : env( 'AUTHORISATION_SITE_IP_BLOCKED_MINIMUM_DELAY' );
        
        // get maximum delay
        $maximumDelay = env( $this->appCode . '_AUTHORISATION_SITE_IP_BLOCKED_MAXIMUM_DELAY' );
        
        // no maximum
        $maximumDelay = $maximumDelay ? $maximumDelay : env( 'AUTHORISATION_SITE_IP_BLOCKED_MAXIMUM_DELAY' );
        
        // create delay
        $delay = rand( $minimumDelay, $maximumDelay );
        
        // delay
        usleep( $delay );        
        
    }
    
}
