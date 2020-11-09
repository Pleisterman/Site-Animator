<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       ListsReadList.php
        function:   reads the lists group and list item rows 
                    of a group or with no group
                    
        Last revision: 05-07-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Lists\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Admin\Site\Lists\Read\ListsReadItems;

class ListsReadList extends BaseClass {

    protected $debugOn = true;
    private $selection = null;
    private $database = null;
    private $readListItems = null;
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
        $this->debug( 'ListsReadList groupId: ' . $groupId );
                
        // create read list items
        $this->readListItems = new ListsReadItems( $this->database, $this->selection );
        
        // group id is null / else
        if( $groupId == null ){
            
            // set order
            $order['column'] = 'name';
            // set direction
            $order['direction'] = 'ASC';
            
            // get rows
            $rows = SiteOptions::getGroupOptions( $this->database, 
                                                  $groupId, 
                                                  'listGroup', 
                                                  $order );
            // get rows

            // return result
            return $this->createRootResult( $rows );
            
        }
        else {
            
            // set order
            $order['column'] = 'sequence';
            // set direction
            $order['direction'] = 'ASC';
            
            // get rows
            $rows = SiteOptions::getOptionOptions( $this->database, 
                                                   $groupId );

            // return result
            return $this->createResult( $rows );

        }
        // group id is null / else

    }
    private function createRootResult( $rows ){
        
        // create result
        $result = array(
            'groups' => array()
        );
        // create result
        
        // loop over rows
        forEach( $rows as $row ) {

            // read item
            $item = $this->readListItems->read( $row->id );
            
            // set count
            $item['groupCount'] = 1;
            
            // create group
            $result['groups'][$row->name] = $item;
            
        }
        // loop over groups
        
        // return result
        return $result;
        
    }
    private function createResult( $rows ){
        
        // create result
        $result = array(
            'groups' => array()
        );
        // create result
                
        // loop over rows
        forEach( $rows as $row ) {

            // read item
            $item = $this->readListItems->read( $row->id );

            // set count
            $item['groupCount'] = count( $rows );

            // add item to result
            $result['groups'][$item['name']] = $item;
           
        }
        // loop over rows

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
