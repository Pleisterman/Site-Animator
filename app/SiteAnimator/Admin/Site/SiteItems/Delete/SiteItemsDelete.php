<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteItemsDelete.php
        function:   deletes a site items row
                    
        to do:      check usage
                    remove options with site item
                    
        Last revision: 10-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\SiteItems\Delete;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\SiteItems;

class SiteItemsDelete extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function delete( $selection ){

        // selection id ! set
        if( !isset( $selection['id'] ) || 
            $selection['id'] == null ){
            
            // error
            return array( 'criticalError' => 'id not set' );
            
        }
        // selection id ! set
        
        // delete site item
        SiteItems::deleteSiteItem( $this->database, $selection );        
        
        // return ok
        return array( 'ok' );
        
    }
    
}
