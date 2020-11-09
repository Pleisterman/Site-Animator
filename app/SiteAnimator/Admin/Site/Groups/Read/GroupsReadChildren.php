<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsReadChildren.php
        function:   
                    
        Last revision: 18-03-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Groups\Read;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;

class GroupsReadChildren extends BaseClass {

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
    public function read( $groupId, $type, $orderByColumn ){

        // create order by
        $orderBy = array(
            'column'    => $orderByColumn,
            'direction' => 'ASC'
        );
        // create order by
                
        // get groups
        $groups = SiteOptions::getGroupOptions( $this->database, $groupId, $type, $orderBy );
        
        // create result
        $result = array( );

        // loop over groups
        forEach( $groups as $group ) {

            // get id
            $id = $group->name;
            
            // create group
            $result[$id] = $this->createGroup( $group, $type, $orderByColumn );
            
        }
        // loop over groups
        
        // return result
        return $result;
        
    }
    private function createGroup( $group, $type, $orderByColumn ) {

        // create result
        $result = array(
            'id'            =>  $group->id,
            'parentId'      =>  $group->parent_id,
            'name'          =>  $group->name,
            'groupType'     =>  $type,
            'updatedAt'     =>  $group->updated_at
        );
        // create result

        // collapsed / else
        if( isset( $this->selection['openGroups'] ) && in_array( $group->id, $this->selection['openGroups'] ) ){
        
            // create read children
            $readChildren = new GroupsReadChildren( $this->database, $this->selection );

            // read groups
            $groups = $readChildren->read( $group->id, $type, $orderByColumn );

            // has groups
            if( count( $groups ) > 0 ){
            
                // add collapsed
                $result['collapsed'] = false;
            
                // set has groups
                $result['hasGroups'] = true;

                // set groups
                $result['groups'] = $groups;
                
            }
            // has groups
            
        }
        else {

            // add collapsed
            $result['collapsed'] = true;
            
            // has groups
            $result['hasGroups'] = $this->hasGroups( $group->id, $type );


        }
        // collapsed / else
        
        // return result
        return $result;
            
    }
    private function hasGroups( $groupId, $type ){
        
        // get group count
        $count = SiteOptions::getGroupCount( $this->database, $groupId, $type );
        
        // count > 0
        if( $count > 0 ){
            
            // has groups
            return true;
            
        }
        // count > 0
        
        // no groups                       
        return false;
        
    }
    
    
}
