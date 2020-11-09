<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       SiteOptionsOrder.php
        function:   
                    
        Last revision: 10-05-2020
 
*/

namespace App\SiteAnimator\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SiteOptionsOrder extends Model
{
    static public function getNext( $database, $parentId, $sequence, $type ) {
        
        // create query
        $query = DB::connection( $database )
                 ->table(  'site_options' )
                 ->whereNull( 'site_routes_id' )
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
        
        // type ! null / else
        if( $type != null ){
            
            // add type
            $query->where( 'type', $type );
            
        }
        else {
            
            // add type
            $query->whereNull( 'type' );
            
        }
        // type ! null / else
        
        // return execute
        return $query->first(); 
        
    }    
    static public function getPrevious( $database, $parentId, $sequence, $type ) {
        
        // create query
        $query = DB::connection( $database )
                 ->table(  'site_options' )
                 ->whereNull( 'site_routes_id' )
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
        
        // type ! null / else
        if( $type != null ){
            
            // add type
            $query->where( 'type', $type );
            
        }
        else {
            
            // add type
            $query->whereNull( 'type' );
            
        }
        // type ! null / else
        
        // return execute
        return $query->first(); 
        
    }    
    static public function reOrder( $database, $parentId, $type ){
        
        // create query
        $query = DB::connection( $database )
                 ->table(  'site_options' )
                 ->where( 'type', $type )
                 ->whereNull( 'site_routes_id' )
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
