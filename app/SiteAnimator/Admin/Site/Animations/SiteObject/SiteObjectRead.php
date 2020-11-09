<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteObjectRead.php
        function:   
                    
        Last revision: 10-08-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Animations\SiteObject;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteOptions;
use App\SiteAnimator\Admin\Site\Animations\SiteObject\SiteObjectReadGroupPath;

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
        
        // get animaiton row
        $animaitonRow = SiteOptions::getOption( $this->database, $siteObject['id'] );    
        
        // row not found
        if( !$animaitonRow ){
            
            // unset id
            $siteObject['id'] = null;
            
            // done 
            return $siteObject;
            
        }
        // row not found
        
        // set text
        $siteObject['text'] = 'replacing animaiton with id: ' . $animaitonRow->id;
        
        // create read group path
        $readGroupPath = new SiteObjectReadGroupPath( $this->database );
        
        // read group path
        $path = $readGroupPath->read( $animaitonRow->parent_id );
        
        // set text
        $siteObject['text'] = $path . $animaitonRow->name;
        
        // return result
        return $siteObject;

    }
    
}
