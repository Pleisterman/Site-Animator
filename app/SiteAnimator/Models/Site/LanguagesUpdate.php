<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       LanguagesUpdateUpdate.php
        function:   
                    
        Last revision: 24-07-2020
 
*/

namespace App\SiteAnimator\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LanguagesUpdate extends Model
{
    
    static public function updateLanguage( $database, $id, $data, $updatedAt ) {

        // create update array
        $updateArray = array(
            'updated_at'        => $updatedAt
        );
        
        // name exists
        isset( $data['name'] ) ? $updateArray['name'] = $data['name'] : null; 
        
        // code exists
        isset( $data['code'] ) ? $updateArray['code'] = $data['code'] : null; 
        
        // abbreviation exists
        isset( $data['abbreviation'] ) ? $updateArray['abbreviation'] = $data['abbreviation'] : null; 
        
        // public exists
        $updateArray['public'] = isset( $data['isPublic'] ) && $data['isPublic'] == "true" ? 1 : 0;
        
        // sequence exists
        isset( $data['sequence'] ) ? $updateArray['sequence'] = $data['sequence'] : null; 
        
        // update site languages row
        DB::connection( $database )
            ->table( 'site_languages' )
            ->where( 'id', $id )    
            ->update( $updateArray );    
        // update site languages row
        
    }
    static public function updateSequence( $database, $id, $sequence, $updatedAt  ) {

        // create update array
        $updateArray = array(
            'sequence'      =>  $sequence,
            'updated_at'    =>  $updatedAt
        );
        // create update array
        
        // update site languages row
        DB::connection( $database )
            ->table( 'site_languages' )
            ->where( 'id', $id )    
            ->update( $updateArray );    
        // update site languages row
        
    }        
   
}
