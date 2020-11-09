<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       TemplatesReadPartParents.php
        function:   reads the template rows of a group or with no group
                    
        Last revision: 15-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Templates\Read;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Templates\Read\TemplatesReadGroups;
use App\SiteAnimator\Admin\Site\Templates\Read\TemplatesReadGroupItems;

class TemplatesReadPartParents extends BaseClass {

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
        
        // debug info
        $this->debug( 'TemplatesReadPartParents id: ' . $this->selection['id'] );

        return array( 'ok' => true );
        
        // create result
        $result = array();
        
        // group id exists
        if( $groupId != null ){
            
            // create templates read group items
            $templatesReadGroupItems = new TemplatesReadGroupItems( $this->database, $this->selection );

            // add items
            $result['items'] = $templatesReadGroupItems->read( $groupId );

        }
        // group id exists
        
        // add groups
        $result['groups'] = $templatesReadGroups->read( $groupId );
        
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
