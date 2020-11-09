<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteItemsReadItemChildren.php
        function:   reads the admin_groups rows of a group or with no group
                    
        Last revision: 15-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\SiteItems\Read;

use App\Http\Base\BaseClass;

class SiteItemsReadItemChildren extends BaseClass {

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
        

        // create result
        $result = array();

        
        // return result
        return $result;
        
    }
    
}
