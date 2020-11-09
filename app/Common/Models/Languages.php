<?php

/*
        @package    Pleisterman/Common
  
        file:       Languages.php
        function:   
                    
        Last revision: 01-01-2020
 
*/

namespace App\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Languages extends Model
{
    
    static public function getLanguages( $database, $isAdmin ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // get languages
        $languages = DB::connection( $database )
                     ->table( $adminOrSite . 'languages' )
                     ->get();

        // create result
        $result = array();
        
        // loop over languages
        forEach( $languages as $language ) {
        
            // add language to result
            $result[$language->id] = array(
                'id'            =>  $language->id,
                'name'          =>  $language->name,
                'code'          =>  $language->code,
                'sequence'      =>  $language->sequence,
                'abbreviation'  =>  $language->abbreviation,
                'isDefault'     =>  $language->is_default == 1 ? true : false
            );
            // add language to result
            
        }    
        // loop over languages
        
        // return result
        return $result;
        
    }
    static public function getLanguage( $database, $isAdmin, $languageId ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // get languages
        $language = DB::connection( $database )
                    ->table( $adminOrSite . 'languages' )
                    ->where( 'id', $languageId )
                    ->first();

        // return result
        return $language;
        
    }
    
}
