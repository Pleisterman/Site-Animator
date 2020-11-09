<?php

/*
        @package    Common
  
        file:       NotFoundController.php
        function:   handles not found routes
  
        Last revision: 22-12-2019
 
*/

namespace App\Common\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotFoundController extends Controller
{
    protected $debugOn = true;
    protected $debugger = null;
    protected $notFoundView = 'common.notFound';
    public function index( Request $request ) {
        
        // create debugger
        $this->createDebugger();
        
        // debug info
        $this->debug( 'CONTROLLER Common Not found index' );
        
        // create view options
        $viewOptions = array(
        );
        // create view options
        
        // create content
        $contents = view( $this->notFoundView, $viewOptions );        
        
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