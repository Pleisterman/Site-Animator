<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       ReadSecureController.php
        function:   handles api read
 
        Last revision: 01-01-2020
 
*/

namespace App\SiteAnimator\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Common\Admin\Translations\Translations as AdminTranslations;
use App\SiteAnimator\Admin\Users\UserOptionsRead as AdminUserOptionsRead;

class ReadSecureController extends Controller
{
    protected $debugOn = true;
    protected $debugger = null;
    private $appCode = false;
    private $database = false;
    public function index( Request $request ) {
        
        // debug is on    
        if( $this->debugOn ){
            
            // get debugger
            $this->debugger = \App::make('Debugger');
            
        }
        // debug is on    
        
        // debug info
        $this->debug( 'CONTROLLER SiteAnimator Read secure index' );

        // get request values
        $this->getRequestValues( $request );
        
        // read
        $result = $this->read( $request->input('subject'),
                               $request->input('selection') );
        
        // return result
        return array( 'result' => $result, 'procesId' => $request->input('procesId') );
        
    }
   private function getRequestValues( $request ){
        
        // get request action
        $action = $request->route()->getAction();
       
        // get database
        $this->database = isset( $action['database'] ) ? $action['database'] : false;
        
        // get app code
        $this->appCode = isset( $action['appCode'] ) ? $action['appCode'] : false;
        
        // debug info
        $this->debug( ' database: ' . $this->database . ' appCode: ' . $this->appCode  );
        
   }
   private function read( $subject, $selectData ){
        
        // choose subject
        switch ( $subject ) {
                        
            // admin user options
            case 'adminUserOptions': {

                // create user
                $userOptions = new AdminUserOptionsRead( $this->database, $this->appCode );
                
                // call user options
                return $userOptions->read( $selectData );
                
            }
            // admin translations
            case 'adminTranslations': {
                
                // create translations
                $translations = new AdminTranslations( );
                
                // return translations call
                return $translations->read( $this->database, $selectData );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( ' readSecureController error get, subject not found: ' . $subject );
                
                // done with error
                return array( 'criticalError' => 'subjectNotFound' );
                
            }
            
        }        
        // done choose subject
        
    }
    private function debug( $message  ){
        
        // debug is on    
        if( $this->debugOn ){
            
            // debug
            $this->debugger->log( $message );
            
        }
        
    }
}