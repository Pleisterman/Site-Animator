<?php

/*
        @package    Common
  
        file:       IpBlockedController.php
        function:   handles ip blocked routes
  
        Last revision: 22-12-2019
 
*/

namespace App\Common\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IpBlockedController extends Controller
{
    protected $debugOn = true;
    protected $debugger = null;
    protected $ipBlockedView = 'common.ipBlocked';
    public function index( Request $request ) {
        
        // create debugger
        $this->createDebugger();
        
        // debug info
        $this->debug( 'CONTROLLER Common Ip blocked index' );
        
        // create view options
        $viewOptions = array(
        );
        // create view options
        
        // create content
        $contents = view( $this->ipBlockedView, $viewOptions );        
        
        // create response
        $response = Response::make( $contents );
        
        // set header
        $response->header( 'Cache-Control', 'max-age=172,800‬' );
        
        //  return response
        return $response;
        
    }
    private function createDebugger( ){
    
        // debug is on    
        if( $this->debugOn ){
            
            // get debugger
            $this->debugger = \App::make('Debugger');
            
        }
        // debug is on    
        
    }
    private function debug( $message  ){
        
        // debug is on    
        if( $this->debugOn ){
            
            // debug
            $this->debugger->log( $message );
            
        }
        // debug is on    
        
    }
}