<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       RememberMeController.php
        function:   handles remmeber me route
  
        Last revision: 09-12-2019
 
*/

namespace App\SiteAnimator\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RememberMeController extends Controller
{
    protected $debugOn = true;
    protected $debugger = null;
    protected $appName = '';
    public function index( Request $request ) {
        
        // debug is on    
        if( $this->debugOn ){
            
            // get debugger
            $this->debugger = \App::make('Debugger');
            
        }
        // debug is on    

        // debug info
        $this->debug( 'CONTROLLER ' . $this->appName . ' RememberMe index' );

        // create result
        $result = array();
        
        // add page token
        $result['token'] = $request->attributes->get( 'adminToken' );   

        // get user name
        $userName = $request->attributes->get( 'adminUserName' );
        
        // user name exists
        if( $userName ){
            
            // add user name
            $result['userName'] = $userName;   
            
        }
        // user name exists
        
        // return error
        return array( 'result' => $result, 'procesId' => $request->input('procesId') );
        
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