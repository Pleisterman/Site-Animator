<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       LoginController.php
        function:   handles remmeber me route
  
        Last revision: 28-12-2019
 
*/

namespace App\SiteAnimator\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    protected $debugOn = true;
    protected $debugger = null;
    public function prepareLogin( Request $request ) {
        
        // create debugger
        $this->createDebugger();

        // debug info
        $this->debug( 'CONTROLLER site animator LoginController prepareLogin' );

        // create result
        $result = array();
        
        // add token
        $result['token'] = $request->attributes->get( 'adminToken' );   

        // return result
        return array( 'result' => $result, 'procesId' => $request->input('procesId') );
        
    }
    public function validatePrepareLogin( Request $request ) {
        
        // create debugger
        $this->createDebugger();

        // debug info
        $this->debug( 'CONTROLLER site animator LoginController validatePrepareLogin' );

        // create result
        $result = array();
        
        // add token
        $result['token'] = $request->attributes->get( 'adminToken' );   

        // return result
        return array( 'result' => $result, 'procesId' => $request->input('procesId') );
        
    }
    public function login( Request $request ) {
        
        // create debugger
        $this->createDebugger();

        // debug info
        $this->debug( 'CONTROLLER site animator LoginController login' );

        // create result
        $result = array();
        
        // add token
        $result['token'] = $request->attributes->get( 'adminToken' );   

        // return result
        return array( 'result' => $result, 'procesId' => $request->input('procesId') );
        
    }
    public function logOut( Request $request ) {
        
        // create debugger
        $this->createDebugger();

        // debug info
        $this->debug( 'CONTROLLER site animator LoginController logOut' );

        // create result
        $result = array();
        
        // return result
        return array( 'result' => $result, 'procesId' => $request->input('procesId') );
        
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