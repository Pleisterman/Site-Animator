<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       AnimationsReadList.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 10-08-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Animations\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Animations\Read\AnimationsReadGroups;
use App\SiteAnimator\Admin\Site\Animations\Read\AnimationsReadGroupItems;

class AnimationsReadList extends BaseClass {

    protected $debugOn = true;
    private $selection = null;
    private $database = null;
    public function __construct( $database, $selection ) {
        
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
        $this->debug( 'AnimationsReadList groupId: ' . $groupId );
                
        // create animationss read groups 
        $animationssReadGroups = new AnimationsReadGroups( $this->database, $this->selection );
        
        // create animationss read group items
        $animationssReadGroupItems = new AnimationsReadGroupItems( $this->database, $this->selection );
        
        // create result
        $result = array();

        // add items
        $result['items'] = $animationssReadGroupItems->read( $groupId );

        // add groups
        $result['groups'] = $animationssReadGroups->read( $groupId );
        
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
