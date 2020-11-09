<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       MediaReadMediaById.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Media;
use App\SiteAnimator\Admin\Site\Media\Directories\MediaDirectoriesMediaPath;
use App\SiteAnimator\Admin\Site\Media\SiteObject\SiteObjectRead as ReadTranslation;

class MediaReadMediaById extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $mediaPath = '';
    public function read( $appCode, $database, $selection ){

        // debug info
        $this->debug( 'MediaReadMediaById media id: ' . $selection['id'] );
        
        // remember app code
        $this->appCode = $appCode;
        
        // remember database
        $this->database = $database;
        
        // get media row
        $mediaRow = Media::getRow( $this->database, $selection['id'] );    
        
        // row ! found
        if( !$mediaRow ){
            
            // return not found
            return array( 'error' => 'media not found' );
            
        }
        // row ! found
        
        // create result
        return $this->createResult( $mediaRow );
        
    }
    private function createResult( $mediaRow ) {
        
        // media ! found
        if( !$mediaRow ){

            // done
            return null;
        
        }
        // media ! found
        
        // create result
        return array(
            'id'            =>  $mediaRow->id,
            'name'          =>  $mediaRow->name,   
            'type'          =>  $mediaRow->type,   
            'groupId'       =>  $mediaRow->site_options_id,   
            'options'       =>  $this->enhanceOptions( json_decode( $mediaRow->options, true ) ),   
            'updatedAt'     =>  $mediaRow->updated_at,   
            'url'           =>  $this->getUrl( $mediaRow->site_options_id, $mediaRow->name ),   
            'fileName'      =>  $mediaRow->file_name,   
            'uploadedAt'    =>  $mediaRow->uploaded_at
        );
        // create result
        
    }
    private function getUrl( $groupId, $name ){
        
        // create media path
        $mediaPathRead = new MediaDirectoriesMediaPath( $this->database, $this->appCode );
        
        // get group url
        $url = $mediaPathRead->getGroupUrl( $groupId );
        
        // return result
        return $url  . '/' . $name;
        
    }
    private function enhanceOptions( $options ){
                
        // loop over options
        foreach( $options as $key => $value ) {
 
            // site object exists
            if( isset( $value['siteObject'] ) ) {
                
                // get site object
                $options[$key] = $this->getSiteObject( $value );
                
            }
            // site object exists
            
            
            // is array
            if ( is_array( $value ) ) {
                
                // call recursive
                $options[$key] = $this->enhanceOptions( $options[$key] );
                
            }
            // is array
            
        }
        // loop over options        
        
        // return result       
        return $options;        
        
    }
    private function getSiteObject( $options ){
        
        // is translation
        if( isset( $options['translation'] ) ){
        
            // create read
            $readTranslation = new ReadTranslation( $this->database );
            
            // read translation
            $options = $readTranslation->read( $options );
            
        }
        // is translation
        
        // return result
        return $options;
        
    }
}
