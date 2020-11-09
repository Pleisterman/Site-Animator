<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       ListsReadItems.php
        function:   reads a list item row  
                    
        Last revision: 12-10-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Lists\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Admin\Site\Lists\Read\ListsReadGroups;

class ListsReadItems extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    private $selection = null;
    private $readListGroups = null;
    public function __construct( $database, $selection ) {
        
        // set database
        $this->database = $database;
        
        // set selection
        $this->selection = $selection;

        // call parent
        parent::__construct();
        
    }
    public function read( $id ){

        // get row
        $row = SiteOptions::getOption( $this->database, 
                                       $id );
        // get row

        // is item / else
        if( $row->type == 'listItem' ){

            // create result
            return $this->createResult( $row );
            
        }
        else {

            // create read list groups
            $this->readListGroups = new ListsReadGroups( $this->database, $this->selection );
            
            // call list group
            return $this->readListGroups->read( $row );
            
        }
        // is item / else

    }
    public function hasItems( $groupId ){

        // get count
        $count = SiteOptions::getOptionOptionCount( $this->database, $groupId );

        // count > 0
        if( $count > 0 ){
            
            // has groups
            return true;
            
        }
        // count > 0
        
        // no groups                       
        return false;
        
    }
    private function createResult( $row ){
        
        // create item array
        $item = array(
            'id'                =>   $row->id,
            'type'              =>   'siteLists',
            'editType'          =>   'lists',
            'isGroup'           =>   false,
            'hasItems'          =>   false,
            'hasGroups'         =>   false,
            'groupType'         =>   'lists',
            'sequence'          =>   $row->sequence,
            'name'              =>   $row->name,
            'title'             =>   $this->getItemTitle( $row ),
            'groupId'           =>   $row->parent_id,
            'updatedAt'         =>   $row->updated_at
        );
        // create item array

        // return result
        return $item;
            
    }
    private function getItemTitle( $row ){
        
            // create title
            $title = '<nobr>' . $row->name . '</nobr>';
            
            // return title
            return $title;
            
    }
    
}
