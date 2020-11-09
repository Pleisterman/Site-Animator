<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       MediaReadGroupItems.php
        function:   reads the media rows for a group or group is null 
                    checks if a group has items
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Media;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Admin\Site\Media\Directories\MediaDirectoriesMediaPath;

class MediaReadGroupItems extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $selection = null;
    private $groupId = null;
    private $result = null;
    private $mediaPath = '/';
    public function __construct( $appCode, $database, $selection ) {
        
        // remember app code
        $this->appCode = $appCode;
        
        // set database
        $this->database = $database;
        
        // set selection
        $this->selection = $selection;

        // call parent
        parent::__construct();
        
    }
    public function read( $groupId ){

        // remember group id
        $this->groupId = $groupId; 
        
        // get item rows
        $rows = Media::getGroupMedia( $this->database, 
                                      $groupId );
        // get item rows

        // create media path
        $mediaPathRead = new MediaDirectoriesMediaPath( $this->database, $this->appCode );
        
        // get group url
        $url = $mediaPathRead->getGroupUrl( $groupId );
        
        // create result
        $this->createResult( $rows, $url );

        // return result
        return $this->result;
        
    }
    public function hasItems( $groupId ){
        
        // get count
        $count = Media::getItemCount( $this->database, $groupId );
        
        // count > 0
        if( $count > 0 ){
            
            // has groups
            return true;
            
        }
        // count > 0
        
        // no groups                       
        return false;
        
    }
    private function createResult( $rows, $url ){
        
        // create empty result
        $this->result = array();
        
        // loop over rows
        forEach( $rows as $row ) {

            // add item
            $this->addItemToResult( $row, $url );
            
        }
        // loop over rows

    }
    private function addItemToResult( $row, $url ){
        
            // create item array
            $item = array(
                'id'                =>   $row->id,
                'type'              =>   'siteMedia',
                'editType'          =>   'media',
                'displayType'       =>   $row->type,
                'url'               =>   $url . '/' . $row->name,
                'isItem'            =>   true,
                'name'              =>   $row->name,
                'uploadedAt'        =>   $row->uploaded_at,
                'fileName'          =>   $row->file_name,
                'title'             =>   $this->getItemTitle( $row ),
                'groupId'           =>   $this->groupId
            );
            // create item array
            
            // add item to result
            array_push( $this->result, $item );
            
    }
    private function getItemTitle( $row ){
        
            // create title
            $title = '<nobr>' . $row->name . '</nobr>';
            
            // return title
            return $title;
            
    }
    
}
