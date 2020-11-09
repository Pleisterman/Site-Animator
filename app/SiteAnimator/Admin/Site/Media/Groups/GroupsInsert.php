<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsInsert.php
        function:   
                    
        Last revision: 14-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Groups;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Groups\Insert\Common\GroupsPrepareInsert;
use App\SiteAnimator\Admin\Site\Media\Directories\MediaDirectoriesMediaPath;
use App\SiteAnimator\Admin\Site\Media\Directories\MediaDirectoriesInsert;
use App\SiteAnimator\Admin\Site\Groups\Insert\Common\GroupsInsertSave;

class GroupsInsert extends BaseClass {

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
    public function insert( $data ){
        
        // debug info
        $this->debug( 'media GroupsInsert' );
            
        // construct prepare insert
        $prepareInsert = new GroupsPrepareInsert( $this->database, $this->appCode );

        // prepare insert        
        $prepareInsertResult = $prepareInsert->prepareInsert( $data );

        // has result
        if( $prepareInsertResult ){
            
            // return result
            return $prepareInsertResult;
            
        }
        // has result

        // create directory
        $this->createGroupDirectory( $data );
        
        // construct insert save
        $insertSave = new GroupsInsertSave( $this->database, $this->appCode );

        // save insert        
        return $insertSave->save( $data );
        
    }
    private function createGroupDirectory( $data ) {
        
        // create media directories media path
        $mediaDirectories = new MediaDirectoriesMediaPath( $this->database, $this->appCode );
        
        // get path
        $path = $mediaDirectories->getGroupPath( $data['parentId'] );
        
        // add name
        $path .= '/' . $data['name'];

        // create directories insert
        $directoriesInsert = new MediaDirectoriesInsert( $this->database, $this->appCode );
        
        // call directories insert
        $directoriesInsert->createDirectory( $path );
        
    }
    
}
