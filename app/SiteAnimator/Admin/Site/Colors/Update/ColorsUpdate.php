<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       ColorsUpdate.php
        function:   
                    
        Last revision: 11-05-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Colors\Update;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Colors\Update\ColorsPrepareUpdate;
use App\SiteAnimator\Admin\Site\Colors\Update\ColorsUpdateSave;

class ColorsUpdate extends BaseClass {

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
        $prepareUpdate = new ColorsPrepareUpdate( $this->database, $this->appCode );

        // prepare update        
        $prepareUpdateResult = $prepareUpdate->prepareUpdate( $selection, $data );

        // has result
        if( $prepareUpdateResult ){
            
            // return result
            return $prepareUpdateResult;
            
        }
        // has result
        
        // construct colors save
        $colorsSave = new ColorsUpdateSave( $this->database, $this->appCode );

        // save colors        
        return $colorsSave->save( $selection, $data );
        
    }
    
}
