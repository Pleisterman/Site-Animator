<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       LanguagesOrder.php
        function:   
                    
        Last revision: 24-07-2020
 
*/

namespace App\SiteAnimator\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LanguagesOrder extends Model
{
    static public function getNext( $database, $sequence ) {
        
        // create query
        $query = DB::connection( $database )
                 ->table(  'site_languages' )
                 ->where(  'sequence', $sequence + 1 );
        // create query
            
        // return execute
        return $query->first(); 
        
    }    
    static public function getPrevious( $database, $sequence ) {
        
        // create query
        $query = DB::connection( $database )
                 ->table(  'site_languages' )
                 ->where(  'sequence', $sequence - 1 );
        // create query
                    
        // return execute
        return $query->first(); 
        
    }    
    static public function reOrder( $database ){
        
        // create query
        $query = DB::connection( $database )
                 ->table(  'site_languages' )
                 ->orderBy( 'sequence', 'ASC' );
        // create query
            
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
                ->table(  'site_languages' )
                ->where( 'id', $row->id )
                ->update( $updateArray );    
            // update site options row
                
            $sequence++;
            
        }
        // loop over rows
        
        
    }
    
}
