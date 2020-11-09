<?php

/*
        @package    Pleisterman/Common
  
        file:       ResetDebuggerLog.php
        function:   
                    
        Last revision: 22-12-2019
 
*/

namespace App\Common\Http\Middleware;

use Closure;

class ResetDebuggerLog {
    
    protected $debugOn = true;
    protected $debugger = null;
    public function handle( $request, Closure $next )
    {
        
        // get debugger
        $this->debugger = \App::make( 'Debugger' );
        
        // debug info
        $this->debug( 'MIDDLEWARE ResetDebuggerLog' );
        
        // get request action
        $action = $request->route()->getAction();
       
        // create prefix
        $prefix = isset( $action['appCode'] ) ? $action['appCode'] . '_' : 'COMMON_';
        
        // add admin / site
        $prefix .= isset( $action['isAdmin'] ) && $action['isAdmin'] ? 'ADMIN_' : 'SITE_';
        
        // debug info
        $this->debug( 'prefix: ' . $prefix );
        
        // admin clear log
        if( env( $prefix . 'DEBUG_CLEAR_LOG' ) ){
            
            // clear log
            $this->debugger->clearLog();
            
            // debug info
            $this->debug( 'log cleared ' );
            
        }
        // admin clear log
        
        // follow the flow
        return $next( $request );
        
    }
    public function debug( $message  ){
        
        // debug is on    
        if( $this->debugOn ){
            
            // debug
            $this->debugger->log( $message );
            
        }
        // debug is on    
        
    }
}
