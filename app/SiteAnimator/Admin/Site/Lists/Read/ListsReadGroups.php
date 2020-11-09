<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       ListsReadGroups.php
        function:   reads the translation_ids rows for a group or with no group  
                    
        Last revision: 05-07-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Lists\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Admin\Site\Lists\Read\ListsReadItems;

class ListsReadGroups extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    private $selection = null;
    public function __construct( $database, $selection ) {
        
        // set database
        $this->database = $database;
        
        // set selection
        $this->selection = $selection;

        // call parent
        parent::__construct();
        
    }
    public function read( $groupRow ){

        // create result
        $result = array(
            'id'            =>  $groupRow->id,
            'subject'       =>  'siteLists',
            'type'          =>  $groupRow->type,
            'sequence'      =>  $groupRow->sequence,
            'editType'      =>  'lists',
            'groupType'     =>  'group',
            'isGroup'       =>  true,
            'name'          =>  $groupRow->name,
            'updatedAt'     =>  $groupRow->updated_at
        );
        // create result

        // collapsed / else
        if( isset( $this->selection['openGroups'] ) && in_array( $groupRow->id, $this->selection['openGroups'] ) ){
        
            // get items
            $groupItems = $this->getGroupItems( $groupRow->id );

            // has groups
            if( count( $groupItems ) > 0 ){
            
                // set ! collapsed
                $result['collapsed'] = false;
            
                // set has groups
                $result['hasGroups'] = true;

                // set groups
                $result['groups'] = $groupItems;
                
            }
            // has groups


        }
        else {

            // set collapsed
            $result['collapsed'] = true;
            
            // has groups
            $result['hasGroups'] = $this->groupHasItems( $groupRow->id );

        }
        // collapsed / else
        
        // return result
        return $result;
        
    }
    private function groupHasItems( $groupId ){

        // create group items
        $readGroupitems = new ListsReadItems( $this->database, $this->selection );
        
        // return group items call
        return $readGroupitems->hasItems( $groupId );
        
    }
    private function getGroupItems( $groupId ){

        // get rows
        $rows = SiteOptions::getOptionOptions( $this->database, 
                                               $groupId );
        // get rows

        // create items
        $readitems = new ListsReadItems( $this->database, $this->selection );
        
        // create result
        $result = array();
        
        // loop over rows
        forEach( $rows as $row ) {

            // read item
            $item = $readitems->read( $row->id );

            // set count
            $item['groupCount'] = count( $rows );

            // add item to result
            $result[$item['name']] = $item;
           
        }
        // loop over rows

        // return result
        return $result;
        
    }
    
}
