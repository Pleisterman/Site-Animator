<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       ListsReadGroupsAndItems.php
        function:   reads the part rows of a list group
                    checks if a list group has items
                    
        Last revision: 13-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Lists\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Admin\Site\Lists\Read\ListsReadGroups;
use App\SiteAnimator\Admin\Site\Lists\Read\ListsReadItems;

class ListsReadGroupsAndItems extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    private $selection = null;
    private $groupId = null;
    private $result = null;
    private $readListGroups = null;
    private $readListItems = null;
    public function __construct( $database, $selection ) {
        
        // set database
        $this->database = $database;
        
        // set selection
        $this->selection = $selection;

        // create read list groups
        $this->readListGroups = new ListsReadGroups( $database, $selection );
        
        // create read list items
        $this->readListItems = new ListsReadItems( $database, $selection );
        
        // call parent
        parent::__construct();
        
    }
    public function read( $groupId ){

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
            return $this->createResult( $rows, count( $rows ) );

        }
        // group id is null / else
                
    }
    private function createRootResult( $rows ){
        
        // create empty result
        $result = array();
        
        // loop over rows
        forEach( $rows as $row ) {

            // create group
            $result[$row->name] = $this->addGroupToResult( $row, 1 );
            
        }
        // loop over groups
        
        // return result
        return $result;
        
    }
    private function createResult( $rows, $rowCount ){
        
        // create empty result
        $this->result = array();
        
        // loop over rows
        forEach( $rows as $row ) {

            // is group / else
            if( $row['type'] == 'listGroup' ){
                
                // read group
                $group = $this->readListGroups->read( $row->id );
                
                // set count
                $group['groupCount'] = $rowCount;
                                
                // add group to result
                array_push( $this->result, $group );
                
            }
            else {
                
                // read item
                $item = $this->readListItems->read( $row->id );
                
                // set count
                $item['itemCount'] = $rowCount;
                                
                // add item to result
                array_push( $this->result, $item );
                
            }
            // is group / else
           
        }
        // loop over rows

    }
    private function addItemToResult( $row, $rowCount ){
        
            // create item array
            $item = array(
                'id'                =>   $row->id,
                'type'              =>   'siteLists',
                'editType'          =>   'lists',
                'isItem'            =>   true,
                'itemCount'         =>   $rowCount,
                'name'              =>   $row->name,
                'title'             =>   $this->getItemTitle( $row ),
                'groupId'           =>   $this->groupId,
                'updatedAt'         =>   $row->updated_at
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
