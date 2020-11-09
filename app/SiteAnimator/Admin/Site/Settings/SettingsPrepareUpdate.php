<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SettingsPrepareUpdate.php
        function:   
                    
        Last revision: 18-02-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Settings;

use App\Http\Base\BaseClass;
use App\Common\Models\Site\Settings;

class SettingsPrepareUpdate extends BaseClass {

    protected $debugOn = true;
    private $appCode = null;
    private $database = null;
    private $hasError = null;
    private $error = null;
    public function __construct( $database, $appCode ){
        
        // call parent
        parent::__construct();
        
        // remember database
        $this->database = $database;
            
        // remember app code
        $this->appCode = $appCode;
        
    }
    public function prepareUpdate( $data ){
        
        // reset has error
        $this->hasError = false;
        
        // validate updated at
        !$this->validateUpdatedAt( $data );
        
        // has error
        if( $this->hasError ){
            
            // create error
            $error = array(
                'error'         =>   $this->error
            );
            // create error
            
            // return error
            return $error;
            
        }
        // has error      
        
    }
    private function validateUpdatedAt( $data ) {
        
        // loop over data
        for( $i = 0; $i < count( $data ); $i++ ){

            $this->debug( 'validateSettings' .  $data[$i]['id'] );
                
            // get setting
            $setting = Settings::getSettingById( $this->database, $data[$i]['id'] ); 
            
            // get date
            $date = \DateTime::createFromFormat( 'Y-m-d H:i:s', $setting->updatedAt ); 
            
            // get data date
            $dataDate = \DateTime::createFromFormat( 'Y-m-d H:i:s', $data[$i]['updatedAt'] ); 
            
            // updated at ! updated at
            if( $date != $dataDate ){

                // set has error
                $this->hasError = true;
                
                // set error
                $this->error = 'dataOutOfDate';
                
                // done
                return;
                
            }
            // updated at ! updated at
            
        }
        // loop over data
        
    }
    
}
