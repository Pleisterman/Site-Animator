<?php

/*
        @package    Pleisterman\CodeAnalyser
  
        file:       Ip.php
        function:   
                    
        Last revision: 04-12-2019
 
*/

namespace App\Common\Admin\Authentication;

use App\Common\Models\Admin\AdminIps;
use App\Common\Base\BaseClass;

class Ip extends BaseClass {
    
    protected $debugOn = false;
    private $database = 'none';
    private $ip = null;
    public function validateIp( $request, $database )
    {
        
        // remember database
        $this->database = $database;
        
        // register ip
        $this->registerIp( $request );
        
        // ip blocked
        if( $this->ip->blocked ){
            
            // invalid
            return false;
            
        }
        // ip blocked
        
        // set ip
        $request->attributes->set( 'ip', $this->ip );
        
        // return valid
        return true;
        
    }
    public function validateRegisteredIp( $request, $database )
    {
        
        // remember database
        $this->database = $database;
        
        // get ip
        $ip = AdminIps::on( $this->database )
                        ->where( 'ip', $request->ip() )->get()->first();
        // get ip
        
        // ip blocked
        if( !$ip || $ip->blocked ){
            
            // invalid
            return false;
            
        }
        // ip blocked
        
        // set ip
        $request->attributes->set( 'ip', $ip );
        
        // return valid
        return true;
        
    }
    private function registerIp( $request ){
        
        // debug
        $this->debug( 'registerIp' );
        
        // get ip
        $this->ip = AdminIps::on( $this->database )
                              ->where( 'ip', $request->ip() )->get()->first();
        
        // ip not found
        if( !$this->ip ){
            
            // create new ip
            $this->ip = new AdminIps();
            $this->ip->setConnection( $this->database );
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
    
}
