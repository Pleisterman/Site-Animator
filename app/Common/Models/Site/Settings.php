<?php

/*
        @package    Pleisterman/Common
  
        file:       Settings.php
        function:   
                    
        Last revision: 11-02-2020
 
*/

namespace App\Common\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Settings extends Model
{
    
    static public function getSettings( $database ) {
        
        // get settings
        $settings = DB::connection( $database )
                        ->table(    'site_settings' )
                        ->select(   'name', 
                                    'value',
                                    'edit_options as editOptions' )
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
        return  DB::connection( $database )
                    ->table(    'site_settings' )
                    ->select(   'name', 
                                'value', 
                                'edit_options as editOptions',
                                'updated_at as updatedAt'  )
                    ->where(    'type', $type )
                    ->where(    'name', $index )
                    ->first();
        // get settings
        
    }    
    static public function getSettingById( $database, $id ) {
        
        // get settings
        return DB::connection( $database )
                       ->table(    'site_settings' )
                       ->select(   'name', 
                                   'value', 
                                   'edit_options as editOptions',
                                   'updated_at as updatedAt'  )
                       ->where(    'id', $id )
                       ->first();
        // get settings
        
    }    
    
}
