<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       app/Service/Common/Debugger.php
        function:   logs debug information to a debug file
 
                    debug on / off: env var: ADMIN_DEBUG_ON
                    create debug file with ip as file name
                    add timestamp
                    add messages
                    add timestamp on destruct
                    add work time 
 
                    clearlog function will truncate the file
  
        Last revision: 01-02-2019
 
*/

namespace App\Service\Common;

use Request;

class Debugger {

    private $debugOn = false;
    private $dir = "\debug\\";
    private $fileName = 'debug';
    private $file = null;
    private $startedAt = null;
    private $ipReplace = array(
        'replace'   =>  array( ":", ";", "..", ".", "/", "\\" ),
        'with'      =>  array( "_", "_", "_", "_", "_", "_" )
    );
    public function __construct( $request )
    {

        // get request action
        $action = $request->route()->getAction();
        
        // create prefix
        $prefix = isset( $action['appCode'] ) ? $action['appCode'] . '_' : 'COMMON_';
        
        // add admin / site
        $prefix .= isset( $action['isAdmin'] ) && $action['isAdmin'] ? 'ADMIN_' : 'SITE_';
        
        // no debugging
        if( !env( $prefix .'DEBUG_ON' ) ){
            
            // done
            return;
        }
        // no debugging
        
        // set debug on
        $this->debugOn = true;
            
        // create dir
        $this->createDir( $action );
        
        // create file name
        $this->createFileName();
        
        // create file
        $this->file = fopen( storage_path() . $this->dir . $this->fileName . ".txt", "a");
        
        // add opening statement
        fwrite( $this->file, "program started at" . date("H:i:s:u", time()) . "\r\n" );

        // remember start time
        $this->startedAt = microtime( true );    
                
    }
    public function log( $message ){
       
        // no debugging
        if( !$this->debugOn ){
            
            // done
            return;
        }
        // no debugging
        
        // write the message
        fwrite( $this->file, $message . "\r\n" );
        
    }
    public function clearLog(){
        
        // no debugging
        if( !$this->debugOn ){
            
            // done
            return;
            
        }
        // no debugging
        
        // close open file
        fclose( $this->file );
        
        // delete the debug files
        @unlink( storage_path() . $this->dir . $this->fileName . ".txt" );
            
        // create file
        $this->file = fopen( storage_path() . $this->dir . $this->fileName . ".txt", "a");
        
        // add opening statement
        fwrite( $this->file, "program started at" . date("H:i:s:u", time()) . "\r\n" );

        // remember start time
        $this->startedAt = microtime( true );    
        
    }
    private function createDir( $action ){

        // create prefix
        $prefix = '\\';
        
        // add app name / common
        $prefix .= isset( $action['appName'] ) ? $action['appName'] : 'common';

        // app name exists
        if( isset( $action['appName'] ) ){
            
            // add seperator
            $prefix .= '\\';
        
            // add admin / site
            $prefix .= isset( $action['isAdmin'] ) && $action['isAdmin'] ? 'admin' : 'site';
            
        }
        // app name exists        
        
        // set dir
        $this->dir = $prefix . $this->dir . '\\';
        
    }
    private function createFileName(){
        
        // create ip name
        $ipName = str_replace( $this->ipReplace['replace'], $this->ipReplace['with'], Request::ip() );
        
        // !empty ipName
        if( !empty( $ipName ) ){
            // set fileName
            $this->fileName = 'debug_' . $ipName;
        }
        // !empty ipName
        
    }
    function __destruct() {
        
        // no debugging
        if( !$this->debugOn ){


            // done
            return;
            
        }
        // no debugging
        
        // write closing statement
        $this->log( "program ended at" . date("H:i:s:u", time()) . "\r\n" );
        // calculate duration
        $duration = microtime( true ) - $this->startedAt;
        // write duration
        $this->log(  'program busy for: ' . $duration . ' seconds' );
        // add separation
        $this->log( '' );
        
    }
    
}