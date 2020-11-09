<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       PagePartsOrder.php
        function:   
                    
        Last revision: 26-04-2020
 
*/

namespace App\SiteAnimator\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PagePartsOrder extends Model
{
    static public function getNext( $database, $routeId, $parentId, $sequence ) {
        
        // create query
        $query = DB::connection( $database )
                 ->table(  'site_options' )
                 ->where(  'site_routes_id', $routeId )
                 ->where(  'sequence', $sequence + 1 );
        // create query
            
        // parent id ! null / else
        if( $parentId != null ){
            
            // add parent id
            $query->where( 'parent_id', $parentId );
            
        }
        else {
            
            // add parent id
            $query->whereNull( 'parent_id' );
            
        }
        // parent id ! null / else
        
        // return execute
        return $query->first(); 
        
    }    
    static public function getPrevious( $database, $routeId, $parentId, $sequence ) {
        
        // create query
        $query = DB::connection( $database )
                 ->table(  'site_options' )
                 ->where(  'site_routes_id', $routeId )
                 ->where(  'sequence', $sequence - 1 );
        // create query
            
        // parent id ! null / else
        if( $parentId != null ){
            
            // add parent id
            $query->where( 'parent_id', $parentId );
            
        }
        else {
            
            // add parent id
            $query->whereNull( 'parent_id' );
            
        }
        // parent id ! null / else
        
        // return execute
        return $query->first(); 
        
    }    
    static public function reOrder( $database, $routeId, $parentId ) {
        
        // create query
        $query = DB::connection( $database )
                 ->table(  'site_options' )
                 ->where(  'site_routes_id', $routeId )
                 ->orderBy( 'sequence', 'ASC' );
        // create query
            
        // parent id ! null / else
        if( $parentId != null ){
            
            // add parent id
            $query->where( 'parent_id', $parentId );
            
        }
        else {
            
            // add parent id
            $query->whereNull( 'parent_id' );
            
        }
        // parent id ! null / else

        // get rows
        $rows = $query->get();

        // create sequence
        $sequence = 0;
        
        // get date time
        $now = new \DateTime( 'now' );            
         
        // create update at
        $updatedAt = $now->format( 'Y-m-d H:i:s' );

        // loop over rows
        forEach( $rows as $row ) {

            // create update array
            $updateArray = array(
                'sequence'      =>  $sequence,
                'updated_at'    =>  $updatedAt
            );
            // create update array

            // update site options row
            DB::connection( $database )
                ->table( 'site_options' )
                ->where( 'id', $row->id )
                ->update( $updateArray );    
            // update site options row
                
            $sequence++;
            
        }
        // loop over rows
        
        
    }
    
}
