<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       MediaInsertSave.php
        function:   
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Media;

class MediaInsertSave extends BaseClass {

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
    public function save( $data, $fileData ){
        
        $this->debug( 'MediaInsertSave group: ' . $data['groupId'] );
        $this->debug( 'MediaInsertSave options: ' . $data['options'] );
       
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );
        
        // create data
        $insertData = array(
            'groupId'   => $data['groupId'],
            'name'      => $data['name'],
            'options'   => $data['options'],
            'sizes'     => '["original"]'
        );
        // create data
        
        // file data exists
        if( isset( $fileData ) ){
        
            // loop over file data
            foreach( $fileData as $index => $value ){
                
                // add file data
                $insertData[$index] = $value;
                
            }
            // loop over file data
            
        }
        // file data exists
        
        // insert media
        $mediaId = Media::insertMedia( $this->database,
                                       $insertData,
                                       $updatedAt );
        // insert media

        // return media id
        return array( 'mediaId' => $mediaId, 'fileData' => $fileData );
        
    }        
    
}
