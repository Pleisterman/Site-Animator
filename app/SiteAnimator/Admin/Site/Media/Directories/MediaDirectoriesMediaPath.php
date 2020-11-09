<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       MediaDirectoriesMediaPath.php
        function:   
                    
        Last revision: 12-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Directories;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;

class MediaDirectoriesMediaPath extends BaseClass {

    private $appCode = null;
    private $database = null;
    private $mediaPath = '';
    public function __construct( $database, $appCode ){

        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function getGroupPath( $groupId ){

        // create base path
        $path = public_path() . '/';
        
        // base dir not empty
        if( env( $this->appCode . '_BASE_DIR' ) != '' ){
            
            // add base dir
            $path .= env( $this->appCode . '_BASE_DIR' ) . '/';
            
        }
        // base dir not empty
        
        // add media directory
        $path .= 'site/media';
        
        // reset media path
        $this->mediaPath = '';
                
        // get media path
        $this->getMediaPath( $groupId );
        
        // return path
        return $path . $this->mediaPath;
        
    }
    public function getGroupUrl( $groupId ){
        
        // create url
        $url = url( '/' );

        // add public
        $url .= '/' . 'public' . '/';
        
        // base dir ! empty
        if( env( $this->appCode . '_BASE_DIR' ) != '' ){
            
            // add base dir
            $url .= env( $this->appCode . '_BASE_DIR' ) . '/';
            
        }
        // base dir ! empty
        
        // add media path
        $url .= 'site/media';

        // get media path
        $this->getMediaPath( $groupId );
        
        // return url
        return  $url . $this->mediaPath;
        
    }
    private function getMediaPath( $groupId ) {
        
        // group id is null
        if( $groupId == null ){
            
            // done
            return;
            
        }
        // group id is null
        
        // get group
        $groupRow = SiteOptions::getOption( $this->database, $groupId );
        
        // add parent to media path        
        $this->mediaPath =  '/' . $groupRow->name . $this->mediaPath;
        
        // call recursive
        $this->getMediaPath( $groupRow->parent_id );
        
    }
    
}
