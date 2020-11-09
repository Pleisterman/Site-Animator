<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteObjectRead.php
        function:   
                    
        Last revision: 29-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Routes\SiteObject;

use App\Common\Base\BaseClass;
use App\SiteAnimator\Models\Site\Routes;
use App\SiteAnimator\Admin\Site\Routes\SiteObject\SiteObjectReadGroupPath;

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
        
        // get route row
        $routeRow = Routes::getRouteById( $this->database, $siteObject['id'] );    
        
        // row not found
        if( !$routeRow ){
            
            // unset id
            $siteObject['id'] = null;
            
            // done 
            return $siteObject;
            
        }
        // row not found
        
        // set text
        $siteObject['text'] = 'replacing route with id: ' . $routeRow->id;
        
        // create read group path
        $readGroupPath = new SiteObjectReadGroupPath( $this->database );
        
        // read group path
        $path = $readGroupPath->read( $routeRow->site_options_id );        
        
        // set text
        $siteObject['text'] = $path . $routeRow->name;
        
        
        // return result
        return $siteObject;

    }
    
}
