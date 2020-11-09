<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       RoutesDelete.php
        function:   
                    
        Last revision: 05-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Routes\Delete;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Routes;
use App\SiteAnimator\Models\Site\SiteOptionsDelete;

class RoutesDelete extends BaseClass {

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
     
        // delete site options
        SiteOptionsDelete::deleteRouteOption( $this->database, $selection['id'] );
        
        // delete route
        Routes::deleteRoute( $this->database, $selection );
        
        // return ok
        return array( 'ok' );
        
    }
    
}
