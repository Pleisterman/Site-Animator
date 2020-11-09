<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       ReadController.php
        function:   handles api read
 
        Last revision: 15-01-2020
 
*/

namespace App\SiteAnimator\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ReadController extends Controller
{
    protected $debugOn = true;
    protected $debugger = null;
    public function index( Request $request ) {
        
        // debug is on    
        if( $this->debugOn ){
            
            // get debugger
            $this->debugger = \App::make('Debugger');
            
        }
        // debug is on    
        
        // debug info
        $this->debug( 'ReadController index' );

        // read
        $result = $this->read( $request->input('subject'),
                               $request->input('what'),
                               $request->input('selection') );
        
        // return result
        return array( 'result' => $result, 'procesId' => $request->input('procesId') );
        
    }
    public function page( Request $request ) {
        
        // read
        $result = array(
            'languageRoutes' => $request->attributes->get( 'languageRoutes' ),
            'page' => $request->attributes->get( 'pageJson' ),
            'message' => 'All is well.'
        );
        
        // return result
        return array( 'result' => $result , 'procesId' => $request->input('procesId') );
        
    }
    private function read( $subject, $what, $selection ){
        
                        
        
    }
    private function debug( $message  ){
        
        // debug is on    
        if( $this->debugOn ){
            
            // debug
            $this->debugger->log( $message );
            
        }
        
    }
}