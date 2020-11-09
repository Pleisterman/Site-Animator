<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       CssReadGroupItems.php
        function:   reads the seqences rows for a group or group is null 
                    checks if a group has items
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Css\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;

class CssReadGroupItems extends BaseClass {

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
        $rows = SiteOptions::getGroupOptions( $this->database, 
                                              $groupId, 
                                              'css', 
                                              array( 'column' => 'name',
                                                     'direction' => 'ASC'
                                                    ));
        // get item rows

        // create result
        $this->createResult( $rows );

        // return result
        return $this->result;
        
    }
    public function hasItems( $groupId ){
        
        // get count
        $count = SiteOptions::getGroupCount( $this->database, $groupId, 'css' );
        
        // count > 0
        if( $count > 0 ){
            
            // has groups
            return true;
            
        }
        // count > 0
        
        // no groups                       
        return false;
        
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
                'type'              =>   'siteCss',
                'editType'          =>   'css',
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
