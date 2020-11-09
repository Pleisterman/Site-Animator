<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteObjectReadGroupPath.php
        function:   
                    
        Last revision: 27-06-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Css\SiteObject;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;

class SiteObjectReadGroupPath extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    private $path = '/';
    public function __construct( $database ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
        
    }
    public function read( $groupId ){
        
        // read group
        $this->readGroup( $groupId );
        
        // return result
        return $this->path;
        
    }
    private function readGroup( $groupId ){

        // group id is null
        if( $groupId == null ){
            
            // done return result
            return;
            
        }
        // row found
        
        // get group
        $groupRow = SiteOptions::getOption( $this->database, $groupId );
        
        // row found
        if( $groupRow ){
            
            // add group to path
            $this->path .= $groupRow->name . '/';
            
            // call recursive
            $this->readGroup( $groupRow->parent_id );
            
        }
        // row found

    }
    
    
}
