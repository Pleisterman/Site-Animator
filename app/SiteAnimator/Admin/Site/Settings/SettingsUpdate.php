<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SettingsUpdate.php
        function:   
                    
        Last revision: 18-02-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Settings;

use App\Http\Base\BaseClass;
use App\SiteAnimator\Admin\Site\Settings\SettingsPrepareUpdate;
use App\SiteAnimator\Admin\Site\Settings\SettingsSave;

class SettingsUpdate extends BaseClass {

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
        $prepareUpdate = new SettingsPrepareUpdate( $this->database, $this->appCode );

        // prepare update        
        $prepareUpdateResult = $prepareUpdate->prepareUpdate( $data );

        // has result
        if( $prepareUpdateResult ){
            
            // return result
            return $prepareUpdateResult;
            
        }
        // has result
        
        // construct settings save
        $settingsSave = new SettingsSave( $this->database, $this->appCode );

        // save settings        
        return $settingsSave->save( $data );
        
    }
    
}
