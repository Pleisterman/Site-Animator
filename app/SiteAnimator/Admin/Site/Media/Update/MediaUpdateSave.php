<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       MediaUpdateSave.php
        function:   
                    
        Last revision: 11-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Media;

class MediaUpdateSave extends BaseClass {

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
    public function save( $id, $data, $fileData ){
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );

        // create data
        $updateData = array(
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
                $updateData[$index] = $value;
                
            }
            // loop over file data
            
        }
        // file data exists
        
        // update media
        Media::updateMedia( $this->database,
                            $id,
                            $updateData,
                            $updatedAt );
        // update media

        
        // return updated at
        return array( 'updatedAt' => $updatedAt, 'fileData' => $fileData );
        
    }        
    
}
