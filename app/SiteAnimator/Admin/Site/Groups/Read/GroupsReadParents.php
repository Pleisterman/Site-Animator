<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       GroupsReadParents.php
        function:   
                    
        Last revision: 18-03-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Groups\Read;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;

class GroupsReadParents extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    public function __construct( $database ) {
        
        // set database
        $this->database = $database;
        
        // call parent
        parent::__construct();
        
    }
    public function read( $groupId ){

        // create result
        $result = array( );
        
        // get row 
        $groupRow = SiteOptions::getOption( $this->database, $groupId );
      
        // group ! exists
        if( !$groupRow ){
        
            // done
            return $result;
            
        }
        // group exists

        // add group
        array_push( $result, $groupId );

        // while parent found
        while( $groupRow->parent_id != null ){
            
            // add group 
            array_push( $result, $groupRow->parent_id );
            
            // get parent row 
            $groupRow = SiteOptions::getOption( $this->database, $groupRow->parent_id );
            
        }
        // while parent found
        
        // return result
        return $result;
        
    }
    
}
