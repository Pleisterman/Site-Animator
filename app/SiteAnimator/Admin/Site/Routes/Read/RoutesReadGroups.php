<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       RoutesReadGroups.php
        function:   reads the routes rows for a group or with no group  
                    
        Last revision: 03-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Routes\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;

class RoutesReadGroups extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    private $selection = null;
    private $result = null;
    public function __construct( $database, $selection ) {
        
        // set database
        $this->database = $database;
        
        // set selection
        $this->selection = $selection;

        // call parent
        parent::__construct();
        
    }
    public function read( $groupId ){
        
        // create order
        $order = array(
            'column'        =>  'name',
            'direction'     =>   'ASC'
        );
        // create order
        
        // get rows
        $rows = SiteOptions::getGroupOptions( $this->database, $groupId, 'routeGroup', $order );

        // create result
        $this->createResult( $rows );

        // return result
        return $this->result;
        
    }
    private function createResult( $rows ){
        
        // create empty result
        $this->result = array();
        
        // loop over rows
        forEach( $rows as $row ) {

            // create group
            $this->result[$row->name] = $this->addGroupToResult( $row );
            
        }
        // loop over groups
        
    }
    private function addGroupToResult( $row ) {

        // create result
        $result = array(
            'id'            =>  $row->id,
            'subject'       =>  'siteRoutes',
            'editType'      =>  'routes',
            'groupType'     =>  'group',
            'isGroup'       =>  true,
            'name'          =>  $row->name
        );
        // create result

        // collapsed / else
        if( isset( $this->selection['openGroups'] ) && in_array( $row->id, $this->selection['openGroups'] ) ){
        
            // get items
            $groupItemsResult = $this->getGroupItems( $row->id );

            // get groups
            $groupGroupsResult = $this->getGroupGroups( $row->id );

            // merge result
            $result = array_merge( $result, $groupItemsResult, $groupGroupsResult );
            
            // set collapsed
            $result['collapsed'] = false;
            
        }
        else {

            // has groups
            $result['hasGroups'] = $this->groupHasGroups( $row->id );

            // has items
            $result['hasItems'] = $this->groupHasItems( $row->id );

        }
        // collapsed / else
        
        // return result
        return $result;
            
    }
    private function groupHasItems( $groupId ){

        // create group items
        $readGroupitems = new RoutesReadGroupItems( $this->database, $this->selection );
        
        // return group items call
        return $readGroupitems->hasItems( $groupId );
        
    }
    private function getGroupItems( $groupId ){

        // create group items
        $readGroupitems = new RoutesReadGroupItems( $this->database, $this->selection );
        
        // read items
        $items = $readGroupitems->read( $groupId );

        // create result
        $result = array();
        
        // has items
        if( count( $items ) > 0 ){

            // set has items
            $result['hasItems'] = true;

            // set groups
            $result['items'] = $items;

        }
        else {
            
            // set ! has items
            $result['hasItems'] = false;

        }
        // has items

        // return result
        return $result;
        
    }
    private function groupHasGroups( $groupId ){

        // get count
        $count = SiteOptions::getGroupCount( $this->database, $groupId, 'routeGroup' );

        // count > 0 / else
        if( $count > 0 ){
           
            // return has groups
            return true;
            
        }
        else {
            
            // return ! has groups
            return false;
            
        }
        // count > 0 / else
        
    }
    private function getGroupGroups( $groupId ){

        // create group groups
        $readGroupGroups = new RoutesReadGroups( $this->database, $this->selection );
        
        // read groups
        $groups = $readGroupGroups->read( $groupId );

        // create result
        $result = array();
        
        // has groups
        if( count( $groups ) > 0 ){

            // set has groups
            $result['hasGroups'] = true;

            // set groups
            $result['groups'] = $groups;

        }
        else {
            
            // set ! has groups
            $result['hasGroups'] = false;

        }
        // has groups

        // return result
        return $result;
        
    }
    
}
