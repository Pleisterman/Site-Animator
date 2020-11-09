<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       CssReadList.php
        function:   reads the css rows of a group or with no group
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Css\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Css\Read\CssReadGroups;
use App\SiteAnimator\Admin\Site\Css\Read\CssReadGroupItems;

class CssReadList extends BaseClass {

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
    public function read( ){
        
        // get group id
        $groupId = $this->getGroupId( );
        
        // debug info
        $this->debug( 'CssReadList groupId: ' . $groupId );
                
        // create css read groups 
        $csssReadGroups = new CssReadGroups( $this->database, $this->selection );
        
        // create css read group items
        $cssReadGroupItems = new CssReadGroupItems( $this->database, $this->selection );
        
        // create result
        $result = array();

        // add items
        $result['items'] = $cssReadGroupItems->read( $groupId );

        // add groups
        $result['groups'] = $csssReadGroups->read( $groupId );
        
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
