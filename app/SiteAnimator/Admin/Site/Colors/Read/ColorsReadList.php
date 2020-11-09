<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       ColorsReadList.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Colors\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Colors\Read\ColorsReadGroups;
use App\SiteAnimator\Admin\Site\Colors\Read\ColorsReadGroupItems;

class ColorsReadList extends BaseClass {

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
        $this->debug( 'ColorsReadList groupId: ' . $groupId );
                
        // create colors read groups 
        $colorsReadGroups = new ColorsReadGroups( $this->database, $this->selection );
        
        // create colors read group items
        $colorsReadGroupItems = new ColorsReadGroupItems( $this->database, $this->selection );
        
        // create result
        $result = array();

        // add items
        $result['items'] = $colorsReadGroupItems->read( $groupId );

        // add groups
        $result['groups'] = $colorsReadGroups->read( $groupId );
        
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
