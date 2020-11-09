<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       MediaDelete.php
        function:   
                    
        Last revision: 10-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Delete;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Media;
use App\SiteAnimator\Admin\Site\Media\Directories\MediaDirectoriesMediaPath;
use App\SiteAnimator\Admin\Site\Media\Directories\MediaDirectoriesDelete;

class MediaDelete extends BaseClass {

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
    public function delete( $selection ){

        // get media row
        $mediaRow = Media::getRow( $this->database, $selection['id'] );

        // media row ! exists
        if( !$mediaRow ){
            
            // error
            return array( 'criticalError' => 'media row not found' );
            
        }
        // media row ! exists
        
        // create media directories media path
        $this->mediaDirectories = new MediaDirectoriesMediaPath( $this->database, $this->appCode );
        
        // get exisiting path
        $existingPath = $this->mediaDirectories->getGroupPath( $mediaRow->site_options_id );
        
        // add media name
        $path = $existingPath . '/' . $mediaRow->name;        
        
        // create directory delete
        $directoryDelete = new MediaDirectoriesDelete();
        
        // remove directory items
        $directoryDelete->deleteDirectoryItems( $path );
        
        // remove directory
        $directoryDelete->deleteDirectory( $path );
        
        // delete media
        Media::deleteMedia( $this->database, $selection );        
        
        // return ok
        return array( 'ok' );
        
    }
    
}
