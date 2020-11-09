<?php

/*
        @package    Pleisterman/Common
  
        file:       Settings.php
        function:   
                    
        Last revision: 12-02-2020
 
*/

namespace App\Common\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Settings extends Model
{
    
    static public function getSettings( $database ) {
        
        // get settings
        $settings = DB::connection( $database )
                        ->table(    'admin_settings' )
                        ->select(   'name', 
                                    'value' )
                        ->get();
        // get settings
        
        // create result
        $result = array();
        
        // loop over settings
        forEach( $settings as $setting ) {
        
            // parse value
            $result[$setting->name] = $setting->value;
            
        }
        // loop over settings        
        
        // return result
        return $result;
        
    }
    static public function getSetting( $database, $type, $index ) {
        
        // get settings
        $setting = DB::connection( $database )
                        ->table(   'admin_settings' )
                        ->select(  'name', 
                                   'value' )
                        ->where(   'type', $type )
                        ->where(   'name', $index )
                        ->get();
        // get settings
        
        // return setting
        return $setting['value'];
        
    }    
}
