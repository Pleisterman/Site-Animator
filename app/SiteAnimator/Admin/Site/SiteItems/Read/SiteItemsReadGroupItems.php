<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteItemsReadGroupItems.php
        function:   reads the site items rows for a group or group is null 
                    checks if a group has items
                    
        Last revision: 09-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\SiteItems\Read;

use App\Http\Base\BaseClass;
use Illuminate\Support\Facades\DB;

class SiteItemsReadGroupItems extends BaseClass {

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
        $rows = $this->getRows( );

        // create result
        $this->createResult( $rows );

        // return result
        return $this->result;
        
    }
    public function hasItems( $groupId ){
        
        // create query
        $query = DB::connection( $this->database )
                     ->table(    'site_items' )
                     ->orderBy(  'type', 'ASC' );
        // create query
        
        // groupid is null / else
        if( $this->groupId != null ){
            
            // add group null to query
            $query->whereNull( 'group_id' );
            
        }
        else {
        
            // add group to query
            $query->where( 'group_id', '=', $groupId );
            
        }
        // groupid is null / else

        // get count
        $count = $query->count();
        
        // count > 0
        if( $count > 0 ){
            
            // has groups
            return true;
            
        }
        // count > 0
        
        // no groups                       
        return false;
        
    }
    private function getRows( ) {
        
        // create query
        $query = DB::connection( $this->database )
                     ->table(    'site_items' )
                     ->orderBy(  'type', 'ASC' );
        // create query
        
        // groupid is null / else
        if( $this->groupId == null ){
            
            // add group null to query
            $query->whereNull( 'group_id' );
            
        }
        else {
        
            // add group to query
            $query->where( 'group_id', '=', $this->groupId );
            
        }
        // groupid is null / else

        // return result
        return $query->get();
        
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
                'type'              =>   'siteItems',
                'editType'          =>   'siteItems',
                'isItem'            =>   true,
                'name'              =>   $row->type,
                'title'             =>   $this->getItemTitle( $row ),
                'groupId'           =>   $this->groupId,
                'partId'           =>    $row->site_options_id
            );
            // create item array
            
            // add item to result
            array_push( $this->result, $item );
            
    }
    private function getItemTitle( $row ){
        
            // create title
            $title = '<nobr>' . $row->type . '</nobr>';
            
            // return title
            return $title;
            
    }
    
}
