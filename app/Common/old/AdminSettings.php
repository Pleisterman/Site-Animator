<?php

/*
        @package    Pleisterman/CodeAnalyser
  
        file:       AdminSettings.php
        function:   
                    
        Last revision: 04-12-2019
 
*/

namespace App\CodeAnalyser\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminSettings extends Model
{
    
    // set connection
    protected $connection = 'codeAnalyser';
    
    // set table
    protected $table = 'admin_settings';

    static public function getSettings( ) {
        
        // create result
        $result = array();
        
        // get settings
        $settings = DB::table( 'code_analyser.admin_settings' )
                       ->select( 'name', 'value' )
                       ->get();
        // get settings
        
        // loop over settings
        forEach( $settings as $setting ) {
        
            // add to setting to result
            $result[$setting->name] = $setting->value;

        }
        // loop over settings        
     
        // return result
        return $result;
        
    }
    
}
