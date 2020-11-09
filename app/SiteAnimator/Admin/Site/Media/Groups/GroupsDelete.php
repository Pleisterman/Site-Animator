<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsDelete.php
        function:   
                    
        Last revision: 14-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Groups;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Models\Site\SiteOptionsDelete;
use App\SiteAnimator\Models\Site\Media;
use App\SiteAnimator\Admin\Site\Media\Directories\MediaDirectoriesMediaPath;
use App\SiteAnimator\Admin\Site\Media\Directories\MediaDirectoriesDelete;
use App\SiteAnimator\Admin\Site\Media\Delete\MediaDelete;

class GroupsDelete extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $mediaDirectories = null;
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
    public function delete( $selection ){
        
            $this->debug( 'media GroupsDelete delete group: ' . $selection['id'] );
            
        // find child
        $child = $this->findChildGroup( $selection['id'] );
        
        // child found / else
        if( $child ){
        
            // delete child
            $this->deleteGroup( $child->id );
            
            // return recall
            return array( 
                'recall'    =>  true
            );
            // return recall
            
        }
        else {
            
            // delete group
            return $this->deleteGroup( $selection['id'] );
            
        }
        // child found / else
        
    }
    private function findChildGroup( $groupId ){
        
        // create child
        $child = false;
        
        // get groups
        $groups = SiteOptions::getOptionOptions( $this->database, $groupId );
        
        // loop over groups
        foreach( $groups as $index => $group ){

            // set child
            $child = $group;
            
            // find child recursive
            $groupChild = $this->findChildGroup( $group->id );
            
            // group child found
            if( $groupChild ){
            
                // set child
                $child = $groupChild;
                
            }
            // group child found
            
        }
        // loop over groups
        
        // return child
        return $child;
        
    }
    private function deleteGroup( $groupId ) {
        
        $this->debug( 'delete group: ' . $groupId );
        
        // get media rows
        $mediaRows = Media::getGroupMedia( $this->database, $groupId );
        
        // has media
        if( count( $mediaRows ) > 0 ){
            
            // delete media
            $this->deleteMedia( $mediaRows[count( $mediaRows ) - 1] );
            
        }
        // has media
        
        // last media 
        if( count( $mediaRows ) <= 1 ){
        
            // delete directory
            $this->deleteGroupDirectory( $groupId );

            // delete group
            SiteOptionsDelete::deleteOption( $this->database, $groupId );        

            // return ready
            return array( 
                'ready'    =>  true
            );
            // return ready

        }
        // last media 
        
        // return recall
        return array( 
            'recall'    =>  true
        );
        // return recall
            
    }
    private function deleteMedia( $mediaRow ) {

        // create nedia delete
        $mediaDelete = new MediaDelete( $this->database, $this->appCode );

        // create selection
        $selection = array(
            'id'    => $mediaRow->id
        );
        // create selection
        
        // call delete
        $mediaDelete->delete( $selection );
        
    }
    private function deleteGroupDirectory( $groupId ) {

        // get exisiting path
        $path = $this->mediaDirectories->getGroupPath( $groupId );

        $this->debug( 'delete group directory: ' . $path );
        
        // create directory delete
        $directoryDelete = new MediaDirectoriesDelete();
        
        // remove directory
        $directoryDelete->deleteDirectory( $path );
        
    }
    
}
