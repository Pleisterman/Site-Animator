<?php

/*
        @package    Pleisterman/Common
  
        file:       Colors.php
        function:   
                    
        Last revision: 22-01-2020
 
*/

namespace App\Common\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Colors extends Model
{
    
    static public function getColors( $database, $colorSchemeId ) {
        
        // get colors
        $colors = DB::connection( $database )
                    ->table(  'admin_colors' )
                    ->join(   'admin_color_scheme_colors', 
                              'admin_colors.id', 
                              '=', 
                              'admin_color_scheme_colors.color_id' )
                    ->select( 'admin_colors.id', 
                              'admin_colors.name', 
                              'admin_color_scheme_colors.color', 
                              'admin_colors.can_change' )
                    ->where(  'admin_color_scheme_colors.color_scheme_id', $colorSchemeId )
                    ->get();
        // get colors
        
        // create result
        $result = array();
        
        // loop over colors
        forEach( $colors as $color ) {
        
            // add to color to result
            $result[$color->name] = $color->color;

        }
        // loop over colors        
     
        // return result
        return $result;
        
    }
    
}
