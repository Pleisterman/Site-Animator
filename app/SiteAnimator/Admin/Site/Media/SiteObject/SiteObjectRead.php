<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteObjectRead.php
        function:   
                    
        Last revision: 29-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Media\SiteObject;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Models\Site\Media;
use App\SiteAnimator\Admin\Site\Media\SiteObject\SiteObjectReadGroupPath;

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
        
        // get media row
        $mediaRow = Media::getRow( $this->database, $siteObject['id'] );    
        
        // row not found
        if( !$mediaRow ){
            
            // unset id
            $siteObject['id'] = null;
            
            // done 
            return $siteObject;
            
        }
        // row not found
        
        // set text
        $siteObject['text'] = 'replacing media with id: ' . $mediaRow->id;
        
        // create read group path
        $readGroupPath = new SiteObjectReadGroupPath( $this->database );
        
        // read group path
        $path = $readGroupPath->read( $mediaRow->site_options_id );
        
        
        // set text
        $siteObject['text'] = $path . $mediaRow->name;
        
        
        // return result
        return $siteObject;

    }
    
}
