<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteItemsReadList.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 16-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\SiteItems\Read\Parents;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteItems;
use App\SiteAnimator\Admin\Site\SiteItems\Read\Parents\SiteItemsReadGroups;
use App\SiteAnimator\Admin\Site\SiteItems\Read\Parents\SiteItemsReadGroupItems;
use App\SiteAnimator\Admin\Site\Groups\Read\GroupsReadParents;

class SiteItemsReadList extends BaseClass {

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
        $this->debug( 'SiteItemsReadList groupId: ' . $groupId );
                
        // add selected group to open groups
        $this->addFirstItem( );

        // create site items read groups 
        $siteItemsReadGroups = new SiteItemsReadGroups( $this->database, $this->selection );
        
        // create site items read group items
        $siteItemsReadGroupItems = new SiteItemsReadGroupItems( $this->database, $this->selection );
        
        // create result
        $result = array();

        // add items
        $result['items'] = $siteItemsReadGroupItems->read( $groupId );

        // add groups
        $result['groups'] = $siteItemsReadGroups->read( $groupId );
        
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
    private function addFirstItem( ){

        // add first item defined or false
         if( !isset( $this->selection['addFirstItem'] ) || 
            !$this->selection['addFirstItem'] ){
        
             // done
             return;
             
        }
        // add first item defined and true

        // create read parents
        $firstItem = SiteItems::getFirstPart( $this->database );

        // create read parents
        $readParents = new GroupsReadParents( $this->database );
        
        // call read parents
        $parents = $readParents->read( $firstItem->group_id );
        
        // default open groups
        isset( $this->selection['openGroups'] ) ? 
            $this->selection['openGroups'] : 
            $this->selection['openGroups'] = array();
        // default open groups
        
        // loop over parents
        for( $i = 0; $i < count( $parents ); $i++ ){

            // not in open groups
            if( !in_array( $parents[$i], $this->selection['openGroups'] ) ){
                
                // add to open groups
                array_push( $this->selection['openGroups'], $parents[$i] );
                
            } 
            // not in open groups
            
        }
        // loop over groups
        
        // debug info
        $this->debug( 'openGroups: ' . json_encode( $this->selection['openGroups'] ) );
        
    }
    
}
