<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       UploadController.php
        function:   handles api upload
 
        Last revision: 14-05-2020
 
*/

namespace App\SiteAnimator\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SiteAnimator\Admin\Site\Media\Upload\MediaUpload as SiteMediaUpLoad;
use App\SiteAnimator\Admin\Site\Media\Groups\GroupsUpload as SiteMediaGroupUpLoad;

class UploadController extends Controller
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
        $this->debug( 'CONTROLLER SiteAnimator UploadController index' );

        // get request values
        $this->getRequestValues( $request );
        
        // debug info
        $this->debug( 'PROCES: ' . $request->input('procesId') );

        // upload
        $result = $this->upload( $request );
        
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
   private function getPath( ){

        // return path
        return public_path() . '\\' . env( $this->appCode . '_BASE_DIR' ) . '\\' . 'site\media' . '\\';
        
   }
   private function upload( $request ){

        // debug info
        $this->debug( 'subject: ' . $request->input('subject') );

        // debug info
        $this->debug( 'id: ' . $request->input('id') );
        
        // debug info
        $this->debug( 'groupId: ' . $request->input('groupId') );
        
        // debug info
        $this->debug( 'CONTROLLER SiteAnimator UploadController upload files: ' . json_encode( $_FILES ) );
       
        // get subject
        $subject = $request->input('subject');
        
        // choose subject
        switch ( $subject ) {
                        
            // site media
            case 'siteMedia': {
                
                // create media upload
                $mediaUpload = new SiteMediaUpLoad( $this->database, $this->appCode );
                
                // return media call
                return $mediaUpload->upload( $request );
                
            }
            // site media groups
            case 'siteMediaGroups': {
                
                // create media group upload
                $groupUpload = new SiteMediaGroupUpLoad( $this->database, $this->appCode );
                
                // return media group call
                return $groupUpload->upload( $request );
                
            }
            // default
            default: {
                
                // debug info
                $this->debug( 'UploadController error get, subject not found: ' . $subject );
                
                // done with error
                return array( 'criticalError' => 'subjectNotFound' );
                
            }
        
        }
        // choose subject
       
    }
    private function debug( $message  ){
        
        // debug is on    
        if( $this->debugOn ){
            
            // debug
            $this->debugger->log( $message );
            
        }
        
    }
}