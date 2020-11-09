<?php

/*
        @package    Pleisterman/Common
  
        file:       app/Http/Middleware/Admin/RegisterIp.php
        function:   
                    
        Last revision: 24-12-2019
 
*/

namespace App\Common\Http\Middleware\Admin\Authentication;

use Closure;
use App\Common\Models\Admin\Authentication\AdminIps;
use App\Common\Base\BaseClass;

class RegisterIp extends BaseClass {
    
    protected $debugOn = true;
    private $ip = null;
    private $appCode = null;
    public function handle( $request, Closure $next )
    {

        // debug info
        $this->debug( 'MIDDLEWARE Common admin register ip' );

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
        $request->attributes->set( 'adminIp', $this->ip );

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
        $this->ip = AdminIps::on( $database )
                             ->where( 'ip', $request->ip() )->get()->first();
        
        // ip not found
        if( !$this->ip ){
            
            // create new ip
            $this->ip = new AdminIps();
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
        $minimumDelay = env( $this->appCode . '_AUTHORISATION_ADMIN_IP_BLOCKED_MINIMUM_DELAY' );
        
        // no minimum
        $minimumDelay = $minimumDelay ? $minimumDelay : env( 'AUTHORISATION_ADMIN_IP_BLOCKED_MINIMUM_DELAY' );
        
        // get maximum delay
        $maximumDelay = env( $this->appCode . '_AUTHORISATION_ADMIN_IP_BLOCKED_MAXIMUM_DELAY' );
        
        // no maximum
        $maximumDelay = $maximumDelay ? $maximumDelay : env( 'AUTHORISATION_ADMIN_IP_BLOCKED_MAXIMUM_DELAY' );
        
        // create delay
        $delay = rand( $minimumDelay, $maximumDelay );
        
        // delay
        usleep( $delay );        
        
    }
    
}
