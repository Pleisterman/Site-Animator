<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SiteItemsUpdate.php
        function:   
                    
        Last revision: 10-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\SiteItems\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\SiteItems\Update\SiteItemsPrepareUpdate;
use App\SiteAnimator\Admin\Site\SiteItems\Update\SiteItemsUpdateSave;

class SiteItemsUpdate extends BaseClass {

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
        $prepareUpdate = new SiteItemsPrepareUpdate( $this->database, $this->appCode );

        // prepare update        
        $prepareUpdateResult = $prepareUpdate->prepareUpdate( $selection, $data );

        // has result
        if( $prepareUpdateResult ){
            
            // return result
            return $prepareUpdateResult;
            
        }
        // has result
        
        // construct save
        $updateSave = new SiteItemsUpdateSave( $this->database, $this->appCode );

        // save        
        return $updateSave->save( $selection, $data );
        
    }
    
}
