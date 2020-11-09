<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsReadListByType.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 03-03-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Groups\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Groups\Read\GroupsReadParents;
use App\SiteAnimator\Admin\Site\Groups\Read\GroupsReadChildren;

class GroupsReadListByType extends BaseClass {

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
    public function read( $groupId, $type, $orderBy ){
        
        // open groups ! exists
        if( !isset( $this->selection['openGroups'] ) ){
        
            // create open groups
            $this->selection['openGroups'] = array();
            
        }
        // open groups ! exists
        
        // add selected group to open groups
        $this->addSelectedGroupToOpenGroups( );
        
        // create result
        $result = array();

        // create read children
        $readChildren = new GroupsReadChildren( $this->database, $this->selection );
        
        // selected group id exists / else
        if( isset( $this->selection['selectedGroupId'] ) ){
        
            // add groups
            $result['groups'] = $readChildren->read( null, $type, $orderBy );
            
        }
        else {
            
            // add groups
            $result['groups'] = $readChildren->read( $groupId, $type, $orderBy );

        }
        // selected group id exists / else

        // return result
        return $result;
        
    }    
    private function addSelectedGroupToOpenGroups( ){

        // selected group id not defined
        if( !isset( $this->selection['selectedGroupId'] ) || 
            $this->selection['selectedGroupId'] == null ){
        
            // done
            return;
            
        }
        // group id not defined

        // create read parents
        $readParents = new GroupsReadParents( $this->database );
        
        // call read parents
        $parents = $readParents->read( $this->selection['selectedGroupId'] );
        
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
        $this->debug( 'testink groups: ' . json_encode( $this->selection['openGroups'] ) );
        
    }
    
}
