<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       RoutesReadGroupItems.php
        function:   reads the routes rows for a group or group is null 
                    checks if a group has items
                    
        Last revision: 03-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Routes\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Routes;

class RoutesReadGroupItems extends BaseClass {

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

        // remember group id
        $this->groupId = $groupId; 
        
        // get item rows
        $rows = Routes::getGroupRoutes( $this->database, $groupId );

        // create result
        $this->createResult( $rows );

        // return result
        return $this->result;
        
    }
    public function hasItems( $groupId ){
        
        // get count
        $count = Routes::getGroupRoutesCount( $this->database, $groupId );

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
    private function createResult( $rows ){
        
        // create empty result
        $this->result = array();
        
        // loop over rows
        forEach( $rows as $row ) {

            // add item
            $this->addItemToResult( $row );
            
        }
        // loop over rows

    }
    private function addItemToResult( $row ){
        
            // create item array
            $item = array(
                'id'                =>   $row->id,
                'type'              =>   'routes',
                'editType'          =>   'routes',
                'isItem'            =>   true,
                'name'              =>   $row->name,
                'title'             =>   $this->getItemTitle( $row ),
                'groupId'           =>   $this->groupId
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
