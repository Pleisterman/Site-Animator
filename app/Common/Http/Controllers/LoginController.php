<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       LoginController.php
        function:   handles remmeber me route
  
        Last revision: 28-12-2019
 
*/

namespace App\Common\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    protected $debugOn = true;
    protected $debugger = null;
    private $database = null;
    protected $appName = null;
    private $view = 'common.login.login';
    public function index( Request $request ) {

        // create debugger
        $this->createDebugger();
        
        // debug info
        $this->debug( 'CONTROLLER Common Login index' );

        // create view options
        $viewOptions = array(
            'userAgent'             =>  $request->attributes->get( 'userAgent' ),
            'isResetPassword'       =>  false,
            'token'                 =>  $request->attributes->get( 'token' )
        );
        // create view options
        
        // create content
        $contents = view( $this->view, $viewOptions );        
        
        // create response
        $response = Response::make( $contents );
        
        // add headers
        $this->addHeaders( $request, $response );
        
        //  return response
        return $response;
        
    }
    private function addHeaders( $request, $response ){
        
        // get headers
        $headers = $request->attributes->get( 'headers' );

        // no headers
        if( !$headers ){
        
            // done 
            return;
            
        }
        // no headers
        
        // loop over headers
        forEach( $headers as $name => $content ){

            // debug info
            $this->debug( "ADD HEADERS : " . $name  . ' value: ' . $content );
            
            // add header
            $response->header( $name, $content );
            
        }
        // loop over headers
        
    }
    public function prepareLogin( Request $request ) {
        
        // debug is on    
        if( $this->debugOn ){
            
            // get debugger
            $this->debugger = \App::make('Debugger');
            
        }
        // debug is on    

        // debug info
        $this->debug( 'CONTROLLER ' . $this->appName . ' LoginController prepareLogin' );

        // create result
        $result = array();
        
        // add token
        $result['token'] = $request->attributes->get( 'token' );   

        // return result
        return array( 'result' => $result, 'procesId' => $request->input('procesId') );
        
    }
    public function validatePrepareLogin( Request $request ) {
        
        // debug is on    
        if( $this->debugOn ){
            
            // get debugger
            $this->debugger = \App::make('Debugger');
            
        }
        // debug is on    

        // debug info
        $this->debug( 'CONTROLLER ' . $this->appName . ' LoginController validatePrepareLogin' );

        // create result
        $result = array();
        
        // add token
        $result['token'] = $request->attributes->get( 'token' );   

        // return result
        return array( 'result' => $result, 'procesId' => $request->input('procesId') );
        
    }
    public function login( Request $request ) {
        
        // debug is on    
        if( $this->debugOn ){
            
            // get debugger
            $this->debugger = \App::make('Debugger');
            
        }
        // debug is on    

        // debug info
        $this->debug( 'CONTROLLER ' . $this->appName . ' LoginController login' );

        // create result
        $result = array();
        
        // add token
        $result['token'] = $request->attributes->get( 'token' );   

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