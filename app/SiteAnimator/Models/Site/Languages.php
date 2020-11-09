<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       Languages.php
        function:   
                    
        Last revision: 02-04-2020
 
*/

namespace App\SiteAnimator\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Languages extends Model
{
    
    static public function getLanguages( $database ) {
        
        // create result
        $result = array();
        
        // get languages
        $siteLanguages = DB::connection( $database )
                             ->table(    'site_languages' )
                             ->select(   'id', 
                                         'name', 
                                         'code',
                                         'sequence', 
                                         'abbreviation', 
                                         'is_default as isDefault', 
                                         'is_public as isPublic', 
                                         'updated_at as updatedAt' )
                             ->get(); 
        // get languages

        // loop over site languages
        forEach( $siteLanguages as $index => $siteLanguage ) {

            // create language
            $language = array(
                'id'            =>  $siteLanguage->id,
                'name'          =>  $siteLanguage->name,
                'code'          =>  $siteLanguage->code,
                'sequence'      =>  $siteLanguage->sequence,
                'abbreviation'  =>  $siteLanguage->abbreviation,
                'isDefault'     =>  $siteLanguage->isDefault == 1 ? true : false,
                'isPublic'      =>  $siteLanguage->isPublic == 1 ? true : false,
                'updatedAt'     =>  $siteLanguage->updatedAt
            );
            
            // add language to result
            array_push( $result, $language );
            
        }
        // loop over site languages
        
        // decode json
        return $result;
        
    }
    static public function getLanguage( $database, $languageId ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_languages' )                
                     ->where( 'id', $languageId );
        // create query

        // return execute
        return $query->first();              
        
    }
            
}
