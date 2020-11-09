<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       MediaUpload.php
        function:   
                    
        Last revision: 11-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Upload;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Media\Insert\MediaInsert;
use App\SiteAnimator\Admin\Site\Media\Update\MediaUpdate;

class MediaUpload extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function upload( $request ){
        
        // id is set / else
        if( $request->input('id') != 'undefined' ){
            
            // create media update
            $mediaUpdate = new MediaUpdate( $this->database, $this->appCode );

            // call media update
            return $mediaUpdate->update( $request );
            
        }
        else {
            
            // create media insert
            $mediaInsert = new MediaInsert( $this->database, $this->appCode );

            // call media insert
            return $mediaInsert->insert( $request );
            
        }
        // id is set / else
       
    }
    
}
