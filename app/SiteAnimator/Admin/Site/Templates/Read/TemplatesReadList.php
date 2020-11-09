<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TemplatesReadList.php
        function:   reads the template rows of a group or with no group
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Templates\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Templates\Read\TemplatesReadGroups;
use App\SiteAnimator\Admin\Site\Templates\Read\TemplatesReadGroupItems;

class TemplatesReadList extends BaseClass {

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
        $this->debug( 'TemplatesReadList groupId: ' . $groupId );
                
        // create templates read groups 
        $templatesReadGroups = new TemplatesReadGroups( $this->database, $this->selection );
        
        // create result
        $result = array(
            'groups'    => array()
        );
        // create result

        // group id exists
        if( $groupId != null ){
            
            // create templates read group items
            $templatesReadGroupItems = new TemplatesReadGroupItems( $this->database, $this->selection );

            // add items
            $result['groups'] = $templatesReadGroupItems->read( $groupId );

        }
        // group id exists
        
        // add groups
        $result['groups'] = array_merge( $result['groups'], $templatesReadGroups->read( $groupId ) );
        
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
