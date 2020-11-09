<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       MediaInsert.php
        function:   
                    
        Last revision: 11-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Media\Insert\MediaPrepareInsert;
use App\SiteAnimator\Admin\Site\Media\Insert\MediaInsertSave;
use App\SiteAnimator\Admin\Site\Media\Directories\MediaDirectoriesMediaPath;
use App\SiteAnimator\Admin\Site\Media\Directories\MediaDirectoriesInsert;
use App\SiteAnimator\Admin\Site\Media\Files\MediaGetMediaType;
use App\SiteAnimator\Admin\Site\Media\Files\MediaUploadFile;


class MediaInsert extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $error = null;
    private $data = null;
    private $fileData = null;
    private $mediaType = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function insert( $request ){
        
        // get data
        $this->getData( $request );
        
        // prepate insert
        $this->prepareInsert( );
        
        // has error
        if( $this->error ){
            
            // return error
            return $this->error;
            
        }
        // has error
        
        // insert media
        $this->insertMedia( );
        
        // has error
        if( $this->error ){
            
            // return error
            return $this->error;
            
        }
        // has error
        
        // construct insert save
        $insertSave = new MediaInsertSave( $this->database, $this->appCode );

        // save insert        
        return $insertSave->save( $this->data, $this->fileData );
        
    }
    private function getData( $request ){

        // create data
        $this->data = array(
            'groupId'   =>  $request->input( 'groupId' ) == "null" ? null : $request->input( 'groupId' ),
            'name'      =>  $request->input( 'name' ),
            'options'   =>  $request->input( 'options' )
        );
        // create data
        
    }
    private function prepareInsert( ) {
        
        // construct prepare insert
        $prepareInsert = new MediaPrepareInsert( $this->database, $this->appCode );

        // prepare insert        
        $prepareInsertResult = $prepareInsert->prepareInsert( $this->data );

        // has result
        if( $prepareInsertResult ){
            
            // return result
            $this->error = $prepareInsertResult;
            
        }
        // has result

    }
    private function insertMedia( ){

        // create media directories media path
        $mediaDirectories = new MediaDirectoriesMediaPath( $this->database, $this->appCode );
        
        // get path
        $path = $mediaDirectories->getGroupPath( $this->data['groupId'] );
        
        // add name
        $path .= '/' . $this->data['name'];

        // get media type
        $this->getMediaType();
        
        // has error
        if( $this->error ){
            
            // done with error
            return;
            
        }
        // has error
        
        // upload
        return $this->uploadMedia( $path );
        
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
    private function uploadMedia( $path ) {
        
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
        
        // create media directories media path
        $mediaDirectories = new MediaDirectoriesMediaPath( $this->database, $this->appCode );
        
        // get path
        $url = $mediaDirectories->getGroupUrl( $this->data['groupId'] );
        
        // add name
        $url .= '/' . $this->data['name'];

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
