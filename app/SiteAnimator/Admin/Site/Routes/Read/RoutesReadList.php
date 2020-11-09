<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       RoutesReadList.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 03-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Routes\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Routes\Read\RoutesReadGroups;
use App\SiteAnimator\Admin\Site\Routes\Read\RoutesReadGroupItems;

class RoutesReadList extends BaseClass {

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
        $this->debug( 'RoutesReadList groupId: ' . $groupId );
                
        // create routes read groups 
        $routesReadGroups = new RoutesReadGroups( $this->database, $this->selection );
        
        // create routes read group items
        $routesReadGroupItems = new RoutesReadGroupItems( $this->database, $this->selection );
        
        // create result
        $result = array();

        // add items
        $result['items'] = $routesReadGroupItems->read( $groupId );

        // add groups
        $result['groups'] = $routesReadGroups->read( $groupId );
        
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
