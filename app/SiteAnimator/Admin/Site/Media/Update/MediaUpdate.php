<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       MediaUpdate.php
        function:   
                    
        Last revision: 11-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Media\Update\MediaPrepareUpdate;
use App\SiteAnimator\Admin\Site\Media\Update\MediaUpdateSave;
use App\SiteAnimator\Admin\Site\Media\Directories\MediaDirectoriesMediaPath;
use App\SiteAnimator\Admin\Site\Media\Files\MediaGetMediaType;
use App\SiteAnimator\Admin\Site\Media\Files\MediaUploadFile;
use App\SiteAnimator\Admin\Site\Media\Directories\MediaDirectoriesUpdate;
use App\SiteAnimator\Admin\Site\Media\Directories\MediaDirectoriesDelete;

class MediaUpdate extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $error = null;
    private $data = null;
    private $fileData = null;
    private $mediaType = null;
    private $mediaDirectories = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function update( $request ){
        
        // debug info
        $this->debug( 'is update id: ' . $request->input('id') );
         
        // get data
        $this->getData( $request );
        
        // get id
        $id = $request->input( 'id' );
        
        // construct prepare update
        $prepareUpdate = new MediaPrepareUpdate( $this->database, $this->appCode );

        // prepare update        
        $prepareUpdateResult = $prepareUpdate->prepareUpdate( $id, $this->data );

        // has result
        if( isset( $prepareUpdateResult['error'] ) ){
            
            // return result
            return $prepareUpdateResult;
            
        }
        // has result
        
        // get existing media row
        $existingRow = $prepareUpdateResult;
        
        // create media directories media path
        $this->mediaDirectories = new MediaDirectoriesMediaPath( $this->database, $this->appCode );
        
        // get exisiting path
        $existingPath = $this->mediaDirectories->getGroupPath( $existingRow['groupId'] );

        // update file
        $this->updateFile( $existingRow, $existingPath );
         
        // update directory
        $this->updateDirectory( $existingRow, $existingPath );
         
        // construct media save
        $mediaSave = new MediaUpdateSave( $this->database, $this->appCode );

        // save media        
        return $mediaSave->save( $id, $this->data, $this->fileData );
        
    }
    private function getData( $request ){

        // create data
        $this->data = array(
            'groupId'   =>  $request->input( 'groupId' ) == "null" ? null : $request->input( 'groupId' ),
            'name'      =>  $request->input( 'name' ),
            'options'   =>  $request->input( 'options' ),
            'updatedAt' =>  $request->input( 'updatedAt' )
        );
        // create data
        
    }
    private function updateFile( $existingRow, $existingPath ) {
    
        // file ! exists
        if( !isset( $_FILES['files']['name'] ) && 
            !isset( $_FILES['files']['name'][0] ) ){
            
            // done no file
            return;
            
        }    
        // file ! exists

        // add media name
        $path = $existingPath . '/' . $existingRow['name'];        
        
        // create directory delete
        $directoryDelete = new MediaDirectoriesDelete();
        
        // remove directory items
        $directoryDelete->deleteDirectoryItems( $path );
        
        // get media type
        $this->getMediaType();
        
        // has error
        if( $this->error ){
            
            // done with error
            return;
            
        }
        // has error
        
        // upload media
        $this->uploadMedia( $path );
        
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
        
        // create upload media file
        $uploadMediaFile = new MediaUploadFile(  ); 
        
        // upload
        $uploadResult = $uploadMediaFile->upload( 0, $path ); 
        
        // has error
        if( $uploadResult['error'] ){
            
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
            'fileName'      => $_FILES['files']['name'][0],
            'type'          => $this->mediaType,
            'uploadedAt'    => $uploadedAt
        );
        // create file data
        
    }
    private function updateDirectory( $existingRow, $existingPath ) {
    
        // create directory update
        $directoriesUpdate = new MediaDirectoriesUpdate( $this->database, $this->appCode );
        
        // name changed or group changed
        if( $existingRow['name'] != $this->data['name'] ||
            $existingRow['groupId'] != $this->data['groupId'] ){
            
            // get update path
            $updatePath = $this->mediaDirectories->getGroupPath( $this->data['groupId'] );
            
            // add media name
            $mediaPath = $existingPath . '/' . $existingRow['name'];
        
            // add media name
            $updatePath = $updatePath . '/' . $this->data['name'];
            
            $this->debug( 'existingPath: ' . $existingPath );
            $this->debug( 'updatePath: ' . $updatePath .  ' group: ' . $this->data['name'] );
            
            // update group directory
            $directoriesUpdate->updateDirectory( $mediaPath, $updatePath );
            
        }
        // name changed or group changed
                
    }
    
}
