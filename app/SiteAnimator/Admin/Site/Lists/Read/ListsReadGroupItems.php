<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       ListsReadGroupItems.php
        function:   reads the part rows of a list group
                    checks if a list group has items
                    
        Last revision: 13-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Lists\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;

class ListsReadGroupItems extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    private $selection = null;
    private $groupId = null;
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

        // no group
        if( $groupId == null ){
        
            // no entries
            return array();
            
        }
        // no group
        
        // remember group id
        $this->groupId = $groupId; 
        
        // get item rows
        $rows = $this->getRows( $groupId );

        // create result
        $this->createResult( $rows );

        // return result
        return $this->result;
        
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
    private function getRows( $groupId ) {
        
        // get rows
        return SiteOptions::getOptionOptions( $this->database, 
                                              $groupId,
                                              'listItem' );
        // get rows
                
    }        
    private function createResult( $rows ){
        
        // create empty result
        $this->result = array();
        
        // loop over rows
        forEach( $rows as $row ) {

            // add item
            $this->addItemToResult( $row, count( $rows ) );
            
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
