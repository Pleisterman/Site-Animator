<?php

/*
        @package    Pleisterman/Website
  
        file:       app/Http/Base/BaseClass.php
        function:   adds a debug function to the class
  
        Last revision: 27-01-2019
 
*/

namespace App\Common\Base;

class BaseClass {
    
    protected $debugOn = false;
    protected $debugger = null;
    public function __construct( ) {

        // debug is on    
        if( $this->debugOn ){
            
            // get debugger
            $this->debugger = \App::make( 'Debugger' );
            
        }
        // debug is on    
        
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
