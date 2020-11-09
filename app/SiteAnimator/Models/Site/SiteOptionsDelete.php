<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       SiteOptionsDelete.php
        function:   
                    
        Last revision: 07-04-2020
 
*/

namespace App\SiteAnimator\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SiteOptionsDelete extends Model
{
    
    static public function deleteOption( $database, $optionId ) {
        
        // delete option
        DB::connection( $database )
            ->table( 'site_options' )                
            ->where( 'id', $optionId )
            ->delete( );
        // delete option
            
    }
    static public function deleteRouteOption( $database, $routeId ) {
        
        // delete route options
        DB::connection( $database )
            ->table( 'site_options' )                
            ->where( 'site_routes_id', $routeId )
            ->delete( );
        // delete route options
            
    }
    
}
