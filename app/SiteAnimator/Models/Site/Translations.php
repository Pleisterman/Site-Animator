<?php

/*
        @package    Pleisterman/SiteAnimator
  
        file:       Translations.php
        function:   
                    
        Last revision: 18-04-2020
 
*/

namespace App\SiteAnimator\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Translations extends Model
{
    
    static public function getGroupTranslations( $database, $groupId ) {
        
        // create query
        $query = DB::connection( $database )
                     ->table( 'site_translation_ids' );
        // create query
        
        // group id ! null / else
        if( $groupId != null ){
            
            // add group id
            $query->where( 'site_options_id', $groupId );
            
        }
        else {
            
            // add group id
            $query->whereNull( 'site_options_id' );
            
        }
        // group id ! null / else
        
        // return execute
        return $query->get(); 
        
    }
    static public function getTranslationIdRow( $database, $isAdmin, $id ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // get translations id row
        return DB::connection( $database )
                   ->table(    $adminOrSite . 'translation_ids' )
                   ->select(   'id', 
                               'name', 
                               'site_options_id as groupId', 
                               'options', 
                               'updated_at as updatedAt' )
                   ->where(    'id',
                               '=',
                               $id )
                   ->first();    
        // get translations id row
        
    }
    static public function getTranslationRows(  $database, $isAdmin, $translationIdsId ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // get translations by id
        return DB::connection( $database )
               ->table(    $adminOrSite . 'translation_ids' )
               ->join(     $adminOrSite . 'translations', 
                           $adminOrSite . 'translation_ids.id', 
                           '=', 
                           $adminOrSite . 'translations.translation_id' )
               ->select(   $adminOrSite . 'translations.id', 
                           $adminOrSite . 'translations.language_id as languageId', 
                           'translation' )
               ->where(    $adminOrSite . 'translation_ids.id',
                           '=',
                           $translationIdsId )
               ->get(); 
        // get translations by id
        
    }
    static public function getTranslation( $database, $isAdmin, $translationIdsId, $languageId ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // get translations by id
        return DB::connection( $database )
               ->table(    $adminOrSite . 'translations' )
               ->select(   'translation' )
               ->where(    'translation_id',
                           '=',
                           $translationIdsId )
                ->where(   'language_id', $languageId )
               ->first(); 
        // get translations by id
        
    }
    static public function insertTranslationId(  $database, $isAdmin, $data, $updatedAt ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // insert translation id row
        $id = DB::connection( $database )
                  ->table(    $adminOrSite . 'translation_ids' )
                  ->insertGetId([
                    'name'              => $data['name'],
                    'type'              => $data['type'],
                    'site_options_id'   => $data['groupId'] ? $data['groupId'] : null,
                    'options'           => isset( $data['options'] ) && $data['options'] != null ? json_encode( $data['options'] ) : '{}',
                    'updated_at'        => $updatedAt,
                    'created_at'        => $updatedAt
                  ]);    
        // insert translation id row
    
        // return id
        return $id;
        
    }
    static public function insertTranslation( $database, $isAdmin, $data, $translationId ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // insert translation row
        $id = DB::connection( $database )
                  ->table(    $adminOrSite . 'translations' )
                  ->insertGetId([
                    'language_id'       => $data['languageId'],
                    'translation_id'    => $translationId,
                    'translation'       => $data['translation']
                  ]);    
        // insert translation row
    
        // return id
        return $id;
        
    }
    static public function updateTranslationId(  $database, $isAdmin, $selection, $data, $updatedAt ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // update translation id row
        DB::connection( $database )
            ->table(    $adminOrSite . 'translation_ids' )
            ->where( 'id', $selection['id'] )
            ->update([
                'name'              => $data['name'],
                'type'              => $data['type'],
                'site_options_id'   => $data['groupId'] ? $data['groupId'] : null,
                'options'           => isset( $data['options'] ) && $data['options'] != null ? json_encode( $data['options'] ) : '{}',
                'updated_at'        => $updatedAt
            ]);
        // update translation id row
        
    }
    static public function updateTranslation( $database, $isAdmin, $data ) {
        
        // create adminOrSite 
        $adminOrSite = $isAdmin ? 'admin_' : 'site_';
        
        // update translation row
        DB::connection( $database )
            ->table(    $adminOrSite . 'translations' )
            ->where( 'id', $data['id'] )    
            ->update([
                'translation'       => $data['translation']
            ]);
        // update translation row
    
    }
    static public function deleteTranslation( $database, $selection ) {
    
        // delete translation rows
        DB::connection( $database )
            ->table( 'site_translations' )
            ->where( 'translation_id', $selection['id'] )
            ->delete();    
        // delete translation rows

        // delete translation id row
        DB::connection( $database )
            ->table( 'site_translation_ids' )
            ->where( 'id', $selection['id'] )
            ->delete();    
        // delete translation id row
        
    }
    
}
