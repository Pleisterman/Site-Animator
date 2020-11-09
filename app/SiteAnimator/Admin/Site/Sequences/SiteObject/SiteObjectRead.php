<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteObjectRead.php
        function:   
                    
        Last revision: 29-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Sequences\SiteObject;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Admin\Site\Sequences\SiteObject\SiteObjectReadGroupPath;

class SiteObjectRead extends BaseClass {

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
        
        // get sequence row
        $sequenceRow = SiteOptions::getOption( $this->database, $siteObject['id'] );    
        
        // row not found
        if( !$sequenceRow ){
            
            // unset id
            $siteObject['id'] = null;
            
            // done 
            return $siteObject;
            
        }
        // row not found
        
        // set text
        $siteObject['text'] = 'replacing sequence with id: ' . $sequenceRow->id;
        
        // create read group path
        $readGroupPath = new SiteObjectReadGroupPath( $this->database );
        
        // read group path
        $path = $readGroupPath->read( $sequenceRow->parent_id );
        
        // set text
        $siteObject['text'] = $path . $sequenceRow->name;
        
        // return result
        return $siteObject;

    }
    
}
