<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       RoutesUpdate.php
        function:   
                    
        Last revision: 04-04-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Routes\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Routes\Update\RoutesPrepareUpdate;
use App\SiteAnimator\Admin\Site\Routes\Update\RoutesUpdateSave;

class RoutesUpdate extends BaseClass {

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
    public function update( $selection, $data ){
        
        // construct prepare update
        $prepareUpdate = new RoutesPrepareUpdate( $this->database, $this->appCode );

        // prepare update        
        $prepareUpdateResult = $prepareUpdate->prepareUpdate( $selection, $data );

        // has result
        if( $prepareUpdateResult ){
            
            // return result
            return $prepareUpdateResult;
            
        }
        // has result
        
        // construct translations save
        $translationsSave = new RoutesUpdateSave( $this->database, $this->appCode );

        // save translations        
        return $translationsSave->save( $selection, $data );
        
    }
    
}
