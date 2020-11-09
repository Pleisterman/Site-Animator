<?php

/*
        @package    Pleisterman\SiteAnimator
  
        file:       SettingsSave.php
        function:   
                    
        Last revision: 18-02-2020
 
*/

namespace App\SiteAnimator\Admin\Site\Settings;

use App\Http\Base\BaseClass;
use Illuminate\Support\Facades\DB;

class SettingsSave extends BaseClass {

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
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );
        
        // loop over data
        for( $i = 0; $i < count( $data ); $i++ ){

            // debug info
            $this->debug( 'updateSettings' .  $data[$i]['id'] );
                
            // is string / else
            if( is_string( $data[$i]['value'] ) ){
                
                // set value
                $value = $data[$i]['value'];
                
            }
            else {
                
                // set value
                $value = json_encode( $data[$i]['value'] );
                
            }
            // is string / else
            
            // update setting
            DB::connection( $this->database )
                ->table( 'site_settings' )
                ->where( 'id', $data[$i]['id'] )
                ->update( ['value' => $value, 
                           'updated_at' => $updatedAt] );
            // update setting
            
        }
        // loop over data
                
        // return updated at
        return array( 'updatedAt' => $updatedAt );
    }        
    
}
