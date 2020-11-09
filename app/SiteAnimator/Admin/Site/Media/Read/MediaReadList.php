<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       MediaReadList.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Media\Read\MediaReadGroups;
use App\SiteAnimator\Admin\Site\Media\Read\MediaReadGroupItems;

class MediaReadList extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $selection = null;
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
    public function read( ){
        
        // get group id
        $groupId = $this->getGroupId( );
        
        // debug info
        $this->debug( 'MediaReadList groupId: ' . $groupId );
                
        // create media read groups 
        $mediaReadGroups = new MediaReadGroups( $this->appCode, $this->database, $this->selection );
        
        // create media read group items
        $mediaReadGroupItems = new MediaReadGroupItems( $this->appCode, $this->database, $this->selection );
        
        // create result
        $result = array();

        // add items
        $result['items'] = $mediaReadGroupItems->read( $groupId );

        // add groups
        $result['groups'] = $mediaReadGroups->read( $groupId );
        
        // return result
        return $result;
        
    }
    private function getGroupId( ){

        // create group id
        $groupId = null;
        
        // selection is set and group id is set
        if( isset( $this->selection ) && isset( $this->selection['groupId'] ) ){
            
            // set group id
            $groupId = $this->selection['groupId'];
            
        }
        // selection is set and group id is set
        
        // return result
        return $groupId;
        
    }
    
}
