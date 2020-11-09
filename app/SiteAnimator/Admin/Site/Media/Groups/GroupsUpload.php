<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsUpload.php
        function:   
                    
        Last revision: 13-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Groups;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Media\Directories\MediaDirectoriesMediaPath;
use App\SiteAnimator\Admin\Site\Media\Insert\MediaInsertSave;
use App\SiteAnimator\Admin\Site\Media\Files\MediaGetMediaType;
use App\SiteAnimator\Admin\Site\Media\Directories\MediaDirectoriesInsert;
use App\SiteAnimator\Admin\Site\Media\Files\MediaUploadFile;

class GroupsUpload extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $error = null;
    private $mediaType = null;
    private $mediaDirectories = null;
    private $fileData = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
        // create media directories media path
        $this->mediaDirectories = new MediaDirectoriesMediaPath( $this->database, $this->appCode );
        
    }
    public function upload( $request ){
        
        // get media type
        $this->getMediaType();
        
        // split file name
        $fileNameArray = explode( '.', $_FILES['files']['name'][0] );
        
        // get name
        $name = implode( '.', array_slice( $fileNameArray, 0, count( $fileNameArray ) - 1 ) );

        // 
        $this->debug( 'name: ' . $name );

        // get group
        $groupId = $request->input( 'id' );
        
        // upload media
        $this->uploadMedia( $groupId, $name );
        
        // has error
        if( $this->error ){

            // done with error
            return $this->error;
            
        }
        // has error
        
        // create data
        $data = array(
            'groupId'   =>  $groupId,
            'name'      =>  $name,
            'options'   =>  null
        );
        // create data
        
        // construct insert save
        $insertSave = new MediaInsertSave( $this->database, $this->appCode );

        // save insert        
        return $insertSave->save( $data, $this->fileData );
       
    }
    private function getMediaType( ) {
        
        // construct media types
        $getMediaType = new MediaGetMediaType( $this->database, $this->appCode );

        // get media type        
        $mediaTypeResult = $getMediaType->getType( 0 );

        // has error
        if( isset( $mediaTypeResult['error'] ) ){
            
            // ! no file
            if( $mediaTypeResult['error'] != 'noFile' ){

                // set error
                $this->error = $mediaTypeResult;

            }                
            // no file / else
            
            // done 
            return;

        }
        // has error

        // set type
        $this->mediaType = $mediaTypeResult;
        
    }
    private function uploadMedia( $groupId, $name ) {
        
        // get path
        $path = $this->mediaDirectories->getGroupPath( $groupId );
        
        // add name to path
        $path .= '/' . $name;

        // create directory
        $this->createItemDirectory( $path );
        
        // no files
        if( !isset( $_FILES['files'] ) ){
            
            // done
            return;
            
        }
        // no files
        
        // upload file
        $uploadResult = $this->uploadFile( $path );
        
        // has error
        if( isset( $uploadResult['error'] ) ){
            
            // set error
            $this->error = $uploadResult;
        
            // done with error
            return;
            
        }
        // has error
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $uploadedAt = $now->format( 'Y-m-d H:i:s' );
        
        // get url
        $url = $this->mediaDirectories->getGroupUrl( $groupId );
        
        // add name
        $url .= '/' . $name;

        // create file data
        $this->fileData = array(
            'url'           =>  $url,
            'fileName'      =>  $_FILES['files']['name'][0],
            'type'          =>  $this->mediaType,
            'uploadedAt'    =>  $uploadedAt
        );
        // create file data
        
    }
    private function createItemDirectory( $path ) {
        
        // create directories insert
        $directoriesInsert = new MediaDirectoriesInsert( $this->database, $this->appCode );
        
        // call directories insert
        $directoriesInsert->createDirectory( $path );
        
    }
    private function uploadFile( $path ) {
        
        // create upload media file
        $uploadMediaFile = new MediaUploadFile(  ); 
        
        // upload
        return $uploadMediaFile->upload( 0, $path ); 
        
        
    }
    
}
