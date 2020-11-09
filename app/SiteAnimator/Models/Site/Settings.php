<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       Settings.php
        function:   
                    
        Last revision: 10-01-2020
 
*/

namespace App\SiteAnimator\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Settings extends Model
{
    
    static public function getSettings( $database ) {
        
        $settings = DB::connection( $database )
                        ->table( 'site_settings' )
                        ->get();
        // get settings
        
        // create result array
        $result = array();
        
        // loop over settings
        forEach( $settings as $setting ) {
        
            // get edit settings
            $editOptions = json_decode( $setting->edit_options, true );
        
            // edit type is json / else
            if( $editOptions['type'] == 'json' ){
                
                // add to setting array
                $result[$setting->name] = json_decode( $setting->value, true );
                
            }
            else {
            
                // add to setting array
                $result[$setting->name] = $setting->value;
                
            }
            // edit type is json / else

        }
        // loop over settings

        // return result
        return $result;
        
    }
    
}
