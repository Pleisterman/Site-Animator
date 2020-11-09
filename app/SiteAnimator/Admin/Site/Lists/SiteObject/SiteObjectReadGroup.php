<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteObjectReadGroup.php
        function:   
                    
        Last revision: 07-07-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Lists\SiteObject;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Admin\Site\Lists\SiteObject\SiteObjectReadGroupPath;

class SiteObjectReadGroup extends BaseClass {

    protected $debugOn = true;
    private $database = null;
    public function __construct( $database ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
        
    }
    public function read( $siteObject ){

        // id is ! set or  null
        if( !isset( $siteObject['id'] ) &&
            $siteObject['id'] == null ){
            
            // done 
            return $siteObject;
            
        }
        // id is ! set or  null
        
        // get list group row
        $listGroupRow = SiteOptions::getOption( $this->database, $siteObject['id'] );    
        
        // row not found
        if( !$listGroupRow ){
            
            // unset id
            $siteObject['id'] = null;
            
            // done 
            return $siteObject;
            
        }
        // row not found
        
        // set text
        $siteObject['text'] = 'replacing list group with id: ' . $listGroupRow->id;
        
        // create read group path
        $readGroupPath = new SiteObjectReadGroupPath( $this->database );
        
        // read group path
        $path = $readGroupPath->read( $listGroupRow->parent_id );
        
        // set text
        $siteObject['text'] = $path . $listGroupRow->name;
        
        // return result
        return $siteObject;

    }
    
}
