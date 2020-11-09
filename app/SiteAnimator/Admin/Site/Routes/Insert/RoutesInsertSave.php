<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       RoutesInsertSave.php
        function:   
                    
        Last revision: 04-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Routes\Insert;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Models\Site\Routes;

class RoutesInsertSave extends BaseClass {

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
    public function save( $data ){
     
        // debug info
        $this->debug( 'group: ' . json_decode( $data['groupId'] ) );
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );
        
        // insert route
        $routeId = Routes::insertRoute( $this->database,
                                        $data,
                                        $updatedAt );
        // insert route

        // return route id
        return array( 'routeId' => $routeId );
        
    }        
    
}
