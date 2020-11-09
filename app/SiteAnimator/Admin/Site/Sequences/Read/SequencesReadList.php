<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SequencesReadList.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 03-03-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Sequences\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Sequences\Read\SequencesReadGroups;
use App\SiteAnimator\Admin\Site\Sequences\Read\SequencesReadGroupItems;

class SequencesReadList extends BaseClass {

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
        $this->debug( 'SequencesReadList groupId: ' . $groupId );
                
        // create sequences read groups 
        $sequencesReadGroups = new SequencesReadGroups( $this->database, $this->selection );
        
        // create sequences read group items
        $sequencesReadGroupItems = new SequencesReadGroupItems( $this->database, $this->selection );
        
        // create result
        $result = array();

        // add items
        $result['items'] = $sequencesReadGroupItems->read( $groupId );

        // add groups
        $result['groups'] = $sequencesReadGroups->read( $groupId );
        
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
