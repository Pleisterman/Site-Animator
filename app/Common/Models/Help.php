<?php

/*
        @package    Pleisterman/Common
  
        file:       Help.php
        function:   
                    
        Last revision: 01-01-2020
 
*/

namespace App\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Help extends Model
{
    
    static public function getSubjects( $database, $isAdmin, $languageId ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // get subjects
        $subjects = DB::connection( $database )
                        ->table(  $adminOrSite . 'help_subjects' )
                        ->join(   $adminOrSite . 'translation_ids', 
                                  $adminOrSite . 'translation_ids.name', 
                                  '=', 
                                  $adminOrSite . 'help_subjects.name' )
                        ->join(   $adminOrSite . 'translations', 
                                  $adminOrSite . 'translations.translation_id', 
                                  '=', 
                                  $adminOrSite . 'translation_ids.id' )
                        ->select( $adminOrSite . 'help_subjects.name', 
                                  $adminOrSite . 'translations.translation' )
                        ->where(  $adminOrSite . 'translation_ids.type', 'helpSubject' )
                        ->where(  $adminOrSite . 'translations.language_id', $languageId )
                        ->get();
        // get subjects
        
        // create result
        $result = array();
        
        // loop over subjects
        forEach( $subjects as $subject ) {
        
            // add to subject to result
            $result[$subject->name] = array(
                'translation'   =>  $subject->translation
            );
            // add to subject to result
            
        }
        // loop over subject
     
        // return result
        return $result;
        
    }
    
}
